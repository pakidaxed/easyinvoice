<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Notification;
use App\Models\Unit;
use App\Services\InvoiceService;
use PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param InvoiceService $invoiceService
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(InvoiceService $invoiceService, Request $request)
    {

        $invoices = Invoice::where('user_id', Auth::id())
            ->where('active', true)
            ->orderBy($request->get('filter') ?? 'id', 'desc')
            ->paginate(15)
            ->appends($request->query());
        return view('invoice.index', ['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = Auth::user();
        $clients = Client::where('user_id', Auth::id())->where('active', true)->get();
        $units = Unit::all();
        $cities = City::all();

        return view('invoice.create', [
            'user' => $user,
            'clients' => $clients,
            'units' => $units,
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param InvoiceService $invoiceService
     * @return string
     */
    public function store(Request $request, InvoiceService $invoiceService)
    {

        $validation = Validator::make($request->all(), [
            'payment_term' => 'required|integer|min:1|max:360',
            'client' => 'required|integer|min:1',
            'items' => 'required|json|min:3',
            'vat_percent' => 'required|integer|min:0|max:100'

        ], [
            'items.min' => 'Please add at least 1 item to the invoice',
            'client.min' => 'Please select client'
        ]);


        if ($validation->fails())
            return redirect(route('invoice.create', ['client' => $request->input('client')]))->withErrors($validation)->withInput();


        $arrayFiltered = json_decode($request->input('items'), true);

        $validateItems = Validator::make($arrayFiltered, [
            '*.id' => 'required',
            '*.name' => 'required|min:1|max:255',
            '*.price' => 'required|numeric|min:0.01',
            '*.unit' => 'required|integer',
            '*.qty' => 'required|integer|min:1|max:200'
        ],[
            '*.name.required' => 'The name field is required',
            '*.qty.required' => 'The name field is required',
            '*.price.required' => 'The name field is required',
            '*.price.min' => 'The price must be at least 0.01',
            '*.unit.min' => 'The unit must be selected from the list',
            '*.qty.min' => 'The quantity must be at least 1'
        ]);

        if ($validateItems->fails())
            return redirect(route('invoice.create', ['client' => $request->input('client')]))->withErrors($validateItems)->withInput();


        $invoice = new Invoice();
        $invoice->number = $invoiceService->getInvoiceLastNumber(Auth::id());
        $invoice->invoice_number = $invoiceService->generateInvoiceNumber(Auth::user()->info->prefix);
        $invoice->sum_excl_tax = 0;
        $invoice->sum_incl_tax = 0;
        $invoice->user_id = Auth::id();
        $invoice->client_id = $request->input('client');
        $invoice->payment_term = $request->input('payment_term');
        $invoice->save();

        $invoiceId = $invoice->id;
        foreach ($arrayFiltered as $item) {

            $invoiceItem = new InvoiceItem();
            $invoiceItem->name = $item['name'];
            $invoiceItem->unit_id = $item['unit'];
            $invoiceItem->invoice_id = $invoiceId;
            $invoiceItem->qty = $item['qty'];
            $invoiceItem->price_excl_tax = $item['price'];
            $invoiceItem->price_incl_tax = $invoiceService->getPriceWithTax($item['price'], $request->input('vat_percent'));
            $invoiceItem->save();

            $invoice->sum_excl_tax += $invoiceItem->price_excl_tax * $invoiceItem->qty;
            $invoice->sum_incl_tax += $invoiceItem->price_incl_tax * $invoiceItem->qty;

        }

        $invoice->save();


        return redirect(route('invoice.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param InvoiceService $invoiceService
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(InvoiceService $invoiceService, $id)
    {
        $invoice = Invoice::where('user_id' , Auth::id())->where('id', $id)->firstOrFail();
        $sumInWords = $invoiceService->spellout($invoice->sum_excl_tax);

        return view('invoice.show', [
            'invoice' => $invoice,
            'sumInWords' => $sumInWords
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->where('active', true)->firstOrFail();
        $invoice->active = false;
        $invoice->save();

        return redirect(route('invoice.index'))->with('success', 'Invoice deleted successfully');
    }

    public function isPaid($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->where('active', true)->firstOrFail();
        $invoice->paid = true;
        $invoice->save();

        $notification = new Notification();
        $notification->message = 'Payment approved for invoice ' . $invoice->invoice_number;
        $notification->user_id = Auth::id();
        $notification->save();

        return redirect(route('invoice.index'))->with('success', 'Payment approved');

    }

    public function generatePdf($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->where('active', true)->firstOrFail();
        $pdf = PDF::loadView('invoice.pdf.invoice', ['invoice' => $invoice]);
        return $pdf->download($invoice->invoice_number);
    }
}
