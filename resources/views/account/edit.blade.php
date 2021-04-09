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
                    <div class="card-header">{{ __('My account information') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('account.edit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="first_name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ $user->info->first_name ?? old('first_name') }}"
                                           required
                                           autocomplete="first_name" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ $user->info->last_name ?? old('last_name') }}"
                                           required
                                           autocomplete="last_name" autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="tel"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ $user->info->phone ?? old('phone') }}" required
                                           autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Company code') }}</label>

                                <div class="col-md-6">
                                    <input id="code" type="text"
                                           class="form-control @error('code') is-invalid @enderror" name="code"
                                           value="{{ $user->info->code ?? old('code') }}" required autocomplete="code"
                                           autofocus>

                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vat_code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('VAT code') }}</label>

                                <div class="col-md-6">
                                    <input id="vat_code" type="text"
                                           class="form-control @error('vat_code') is-invalid @enderror" name="vat_code"
                                           value="{{ $user->info->vat_code ?? old('vat_code') }}"
                                           autocomplete="vat_code" autofocus>

                                    @error('vat_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="personal_id"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Personal ID') }}</label>

                                <div class="col-md-6">
                                    <input id="personal_id" type="text"
                                           class="form-control @error('personal_id') is-invalid @enderror"
                                           name="personal_id"
                                           value="{{ $user->info->personal_id ?? old('personal_id') }}"
                                           autocomplete="personal_id" autofocus>

                                    @error('personal_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                           class="form-control @error('address') is-invalid @enderror" name="address"
                                           value="{{ $user->info->address ?? old('address') }}" required
                                           autocomplete="address" autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Post code') }}</label>

                                <div class="col-md-6">
                                    <input id="post_code" type="text"
                                           class="form-control @error('post_code') is-invalid @enderror"
                                           name="post_code" value="{{ $user->info->post_code ?? old('post_code') }}"
                                           required
                                           autocomplete="post_code" autofocus>

                                    @error('post_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <select id="city" type="text"
                                            class="form-select @error('city') is-invalid @enderror" name="city"
                                            required autocomplete="city" autofocus>
                                        <option value="1">Vilnius</option>

                                    </select>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank" class="col-md-4 col-form-label text-md-right">{{ __('Bank') }}</label>

                                <div class="col-md-6">
                                    <select id="bank" type="text"
                                            class="form-select @error('bank') is-invalid @enderror" name="bank"
                                            required autocomplete="bank" autofocus>
                                        <option value="1">Medicinos bankas</option>

                                    </select>
                                    @error('bank')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank_account_number"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Bank account number') }}</label>

                                <div class="col-md-6">
                                    <input id="bank_account_number" type="text"
                                           class="form-control @error('bank_account_number') is-invalid @enderror"
                                           name="bank_account_number"
                                           value="{{ $user->info->bank_account_number ?? old('bank_account_number') }}"
                                           required
                                           autocomplete="bank_account_number" autofocus>

                                    @error('bank_account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prefix"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Invoice prefix') }}</label>

                                <div class="col-md-6">
                                    <input id="prefix" type="text"
                                           class="form-control @error('prefix') is-invalid @enderror" name="prefix"
                                           value="{{ $user->info->prefix ?? old('prefix') }}" required
                                           autocomplete="prefix" autofocus>

                                    @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                                <div class="col-md-6">
                                    <input id="logo" type="file"
                                           class="form-control-file @error('logo') is-invalid @enderror mb-3" name="logo"
                                           value="{{ old('logo') }}">
                                    <img class="img-fluid" height="50" src="{{ asset('storage/images/logos/' . $user->info->logo) }}" alt="Logo">

                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
