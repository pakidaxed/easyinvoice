<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $newInvoices = Invoice::where('user_id', Auth::id())->orderBy('created_at', 'desc')->where('active', true)->take(3)->get();
        $totalInvoicesToday = Invoice::where('user_id', Auth::id())->whereDay('created_at', today())->count();
        $totalInvoicesThisMonth = Invoice::where('user_id', Auth::id())->whereMonth('created_at', today())->count();

        $totalSumThisYear = Invoice::where('user_id', Auth::id())->whereYear('created_at', today())->sum('sum_excl_tax');
        $totalSumThisYearPaid = Invoice::where('user_id', Auth::id())->whereYear('created_at', today())->where('paid', true)->sum('sum_excl_tax');
        $totalSumThisMonth = Invoice::where('user_id', Auth::id())->whereMonth('created_at', today())->sum('sum_excl_tax');
        $totalSumThisMonthPaid = Invoice::where('user_id', Auth::id())->whereMonth('created_at', today())->where('paid', true)->sum('sum_excl_tax');

        $newClients = Client::where('user_id', Auth::id())->orderBy('created_at', 'desc')->where('active', true)->take(3)->get();
        $totalClients = Client::where('user_id', Auth::id())->count();

        $unreadNotifications = Notification::where('user_id', Auth::id())->where('seen', false)->count();

        return view('home', [
            'newInvoices' => $newInvoices,
            'totalSumThisYear' => $totalSumThisYear,
            'totalSumThisYearPaid' => $totalSumThisYearPaid,
            'totalSumThisMonth' => $totalSumThisMonth,
            'totalSumThisMonthPaid' => $totalSumThisMonthPaid,
            'totalInvoicesToday' => $totalInvoicesToday,
            'totalInvoicesThisMonth' => $totalInvoicesThisMonth,
            'newClients' => $newClients,
            'totalClients' => $totalClients,
            'unreadNotifications' => $unreadNotifications
        ]);
    }
}
