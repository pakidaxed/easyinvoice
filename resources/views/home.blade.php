@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 alert alert-primary" role="alert">
                                <h4>Invoices today</h4>
                                <h1>{{ $totalInvoicesToday }}</h1>
                            </div>
                            <div class="col-3 alert alert-success" role="alert">
                                <h4>Invoices this month</h4>
                                <h1>{{ $totalInvoicesThisMonth }}</h1>
                            </div>
                            <div class="col-3 alert alert-danger" role="alert">
                                <h4>Total clients</h4>
                                <h1>{{ $totalClients }}</h1>
                            </div>
                            <div class="col-3 alert alert-warning" role="alert">
                                <h4>Unread notifications</h4>
                                <h1>{{ $unreadNotifications }}</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 alert alert-success" role="alert">
                                <h4>Total sum this year</h4>
                                <h1>Total: {{ $totalSumThisYear }} EUR</h1>
                                <h3>Paid: {{ $totalSumThisYearPaid }} EUR</h3>
                            </div>
                            <div class="col-6 alert alert-success" role="alert">
                                <h4>Total sum this month</h4>
                                <h1>Total: {{ $totalSumThisMonth }} EUR</h1>
                                <h3>Paid: {{ $totalSumThisMonthPaid }} EUR</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h3>Latest invoices created</h3>
                                @foreach($newInvoices as $invoice)
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div class="col-2 px-0">
                                            <a href="{{ route('invoice.show', $invoice->id) }}">
                                                {{ $invoice->invoice_number }}</a>
                                        </div>
                                        <div class="col-3 px-0">
                                            <span>{{ $invoice->client->name }}</span>
                                        </div>
                                        <div class="col-3 px-0">
                                        <span>{{ $invoice->created_at->format('Y-m-d') }}
                                            @if($invoice->isLate() && !$invoice->paid)
                                                <span class="badge bg-danger text-white px-3">Overdue</span>
                                            @elseif($invoice->paid)
                                                <span class="badge bg-success text-white px-3">Paid</span>
                                            @else()
                                                <span class="badge bg-warning px-3">
                                                    {{ $invoice->daysToOverdue() }} days left
                                                </span>
                                            @endif</span>
                                        </div>
                                        <div class="col-2 px-0">
                                            <span>{{ $invoice->sum_excl_tax }}{{ __('€') }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mt-3">
                                <h3>Latest clients added</h3>
                                @foreach($newClients as $client)
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div class="col-3 px-0">
                                            <a href="{{ route('client.edit', $client->id) }}">
                                                {{ $client->name }}</a>
                                        </div>
                                        <div class="col-6 px-0">
                                            <span>{{ $client->comment }}</span>
                                        </div>
                                        <div class="col-3 px-0">
                                        <span>{{ $client->created_at->format('Y-m-d') }}

                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
