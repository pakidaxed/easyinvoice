<?php

namespace App\Http\Controllers;

use App\Models\AccountInfo;
use App\Models\City;
use App\Models\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $clients = Client::where('user_id', Auth::id())->where('active', true)->where('name', 'like', '%' . $request->get('search') . '%')->orderBy('created_at', 'desc')->paginate(5); //paginate(2);
        return view('client.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $cities = City::all();
        return view('client.create', [
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:40',
            'code' => 'required|digits_between:1,20',
            'vat_code' => 'max:20',
            'address' => 'required|max:150',
            'city' => 'required|integer',
            'post_code' => 'max:8',
            'email' => 'email',
            'phone' => 'max:15'
        ]);

        $client = new Client();

        $client->user_id = Auth::id();
        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->vat_code = $request->input('vat_code');
        $client->address = $request->input('address');
        $client->city_id = $request->input('city');
        $client->post_code = $request->input('post_code');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->comment = $request->input('comment');
        $client->save();

        return redirect(route('client.index', $client->id))->with('success', 'New client created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $client = Client::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cities = City::all();
        return view('client.edit', [
            'client' => $client,
            'cities' => $cities
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:40',
            'code' => 'required|digits_between:1,20',
            'vat_code' => 'max:20',
            'address' => 'required|max:150',
            'city' => 'required|integer',
            'post_code' => 'max:8',
            'email' => 'email',
            'phone' => 'max:15'
        ]);

        $client = Client::where('user_id', Auth::id())->where('id', $id)->where('active', true)->firstOrFail();

        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->vat_code = $request->input('vat_code');
        $client->address = $request->input('address');
        $client->city_id = $request->input('city');
        $client->post_code = $request->input('post_code');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->comment = $request->input('comment');
        $client->save();

        return redirect(route('client.edit', $client->id))->with('success', 'Client information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy($id)
    {
        $client = Client::where('user_id', Auth::id())->where('id', $id)->where('active', true)->firstOrFail();
        $client->active = false;
        $client->save();

        return redirect(route('client.index'))->with('success', 'Client deleted successfully');
    }
}
