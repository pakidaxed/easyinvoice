@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Invoice: ') }}{{ $invoice->invoice_number }}
                        <span><a href="{{ route('invoice.download', $invoice->id) }}">
                            <button class="btn-sm btn-success float-right">{{ __('Download PDF') }}</button>
                    </a></span></div>
                    <div class="card-body">
                        <div class="row mb-5 ">
                            <div class="col-8">
                                <h1>INVOICE: {{ $invoice->invoice_number }}</h1>
                                <h3>{{ $invoice->created_at->format('Y-m-d') }}</h3>
                            </div>
                            <div class="col-4">
                                <img class="img-fluid" height="100"
                                     src="{{ asset('storage/images/logos/' . $invoice->user->info->logo) }}" alt="">
                            </div>
                        </div>
                        <div class="row px-4">
                            <div class="col-md-6">
                                <h2>SELLER</h2>
                                <p class="m-0 font-weight-bold">{{ $invoice->user->name }}</p>
                                <p class="m-0">Company code: {{ $invoice->user->info->code }}</p>
                                <p class="m-0">VAT code: {{ $invoice->user->info->vat_code }}</p>
                                <p class="m-0">Address: {{ $invoice->user->info->address }}</p>
                                <p class="m-0">{{ $invoice->user->info->city->name }}
                                    <span>{{ $invoice->user->info->post_code }}</span></p>
                                <p class="m-0 mt-2">Bank name: {{ $invoice->user->info->bank->name }}</p>
                                <p class="m-0">Bank account: {{ $invoice->user->info->bank_account_number }}</p>
                            </div>
                            <div class="col-md-6 px-4">
                                <h2>BUYER</h2>
                                <p class="m-0 font-weight-bold">{{ $invoice->client->name }}</p>
                                <p class="m-0">Company code: {{ $invoice->client->code }}</p>
                                <p class="m-0">VAT code: {{ $invoice->client->vat_code }}</p>
                                <p class="m-0">Address: {{ $invoice->client->address }}</p>
                                <p class="m-0">{{ $invoice->client->city->name }}
                                    <span>{{ $invoice->client->post_code }}</span></p>
                            </div>
                        </div>
                        <div class="row mt-5 px-4">
                            <div class="col-7 p-2 border-bottom border-dark font-weight-bold">Invoice item</div>
                            <div class="col-2 p-2 border-bottom border-dark font-weight-bold">Price</div>
                            <div class="col-2 p-2 border-bottom border-dark font-weight-bold">Price (inc. VAT)</div>
                            <div class="col-1 p-2 border-bottom border-dark font-weight-bold">Quantity</div>
                            @foreach($invoice->items as $item)
                                <div class="col-7 p-2 border-bottom border-gray">{{ $item->name }}</div>
                                <div
                                    class="col-2 p-2 border-bottom border-gray">{{ $item->price_excl_tax }}{{ __('€') }}</div>
                                <div
                                    class="col-2 p-2 border-bottom border-gray">{{ $item->price_incl_tax }}{{ __('€') }}</div>
                                <div
                                    class="col-1 p-2 border-bottom border-gray">{{ $item->qty }} {{ $item->unit->name }}</div>
                            @endforeach
                        </div>
                        <div class="row px-4 mt-3 mb-5">
                            <div class="col-8"><span class="font-weight-bold">Amount in words: </span>{{ $sumInWords }}
                            </div>
                            <div class="col-4 align-self-end p-2 text-right border-bottom border-gray">
                                <h5><span class="font-weight-bold">Net amount:</span>
                                    {{ $invoice->sum_excl_tax }}{{ __('€') }}</h5>
                                <h5><span class="font-weight-bold">VAT:</span>
                                    {{ $invoice->sum_incl_tax - $invoice->sum_excl_tax }}{{ __('€') }}</h5>
                                <h5><span class="font-weight-bold">Total amount (inc. VAT):</span>
                                    {{ $invoice->sum_incl_tax }}{{ __('€') }}</h5>
                            </div>
                        </div>
                        <div class="row mt-5 px-4">
                            <div class="col">Please make the payment in {{ $invoice->payment_term }} days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

