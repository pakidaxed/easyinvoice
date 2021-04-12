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
                    <div class="card-header">{{ __('Create new invoice') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>SELLER</h2>
                                <p class="m-0 font-weight-bold">{{ $user->name }}</p>
                                <p class="m-0">Company code: {{ $user->info->code }}</p>
                                <p class="m-0">VAT code: {{ $user->info->vat_code }}</p>
                                <p class="m-0">Address: {{ $user->info->address }}</p>
                                <p class="m-0">{{ $user->info->city->name }}
                                    <span>{{ $user->info->post_code }}</span></p>
                                <p class="m-0 mt-2">Bank name: {{ $user->info->bank->name }}</p>
                                <p class="m-0">Bank account: {{ $user->info->bank_account_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <h2>BUYER</h2>
                                @error('client')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <invoice-buyer :clients="{{ $clients }}"
                                               :preselected="{{ app('request')->input('client') ?? 0 }}"
                                               :cities="{{ $cities }}"
                                ></invoice-buyer>
                            </div>

                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <invoice-item
                                    :units="{{ $units }}"
                                    :errors="{{ $errors }}"
                                    olds="{{ old('items'), null }}"></invoice-item>
                            </div>
                        </div>
                        <form action="{{ route('invoice.store') }}" method="POST">
                            @csrf
                            <div class="row mt-5 px-3 justify-content-between align-items-center">
                                <div class="payment">
                                    <label for="payment_term">Payment term in days:</label>
                                    <input type="number" id="payment_term" name="payment_term"
                                           step="1" min="1"
                                           value="{{ old('payment_term', 30) }}" size="4">
                                    <label for="vat_percent">VAT %:</label>
                                    <input type="number" id="vat_percent" name="vat_percent"
                                           step="1" min="1"
                                           value="{{ old('vat_percent', 21) }}" size="4">
                                    <input type="hidden" name="client" value="" v-model="clientId">
                                    <input type="hidden" name="items" value="" v-model="invoiceItems">
                                </div>
                                <div class="action">
                                    <button class="btn btn-primary">Generate invoice</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

