<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'easyInvoice') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <style>
body {

}
.top {
    display: flex;
    justify-content: space-between;
}
    </style>
</head>
<body>
<div id="app">
        <div class="top">
            <div class="col-8">
                <h1>INVOICE: {{ $invoice->invoice_number }}</h1>
                <h3>{{ $invoice->created_at->format('Y-m-d') }}</h3>

                <img class="img-fluid" height="100" style="float: right"
                     src="{{ asset('storage/images/logos/' . $invoice->user->info->logo) }}" alt="">
            </div>
        </div>
        <div  style="display: flex">
            <div style="flex: 1">
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
            <div style="flex: 1">
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
            <div class="col-8"><span class="font-weight-bold">Amount in words: </span></div>
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
</body>
</html>
