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
                    <div class="card-header">{{ __('Edit client information') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('client.update', $client->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Client name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ $client->name ?? old('name') }}"
                                           required
                                           autocomplete="name">
                                    @error('name')
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
                                           class="form-control @error('code') is-invalid @enderror"
                                           name="code" value="{{ $client->code ?? old('code') }}"
                                           required
                                           autocomplete="code">

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
                                           value="{{ $client->vat_code ?? old('vat_code') }}"
                                           autocomplete="vat_code" autofocus>

                                    @error('vat_code')
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
                                           value="{{ $client->address ?? old('address') }}" required
                                           autocomplete="address" autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <select id="city" type="text"
                                            class="form-select @error('city') is-invalid @enderror" name="city"
                                            required autocomplete="city">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
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
                                           name="post_code" value="{{ $client->post_code ?? old('post_code') }}"
                                           autocomplete="post_code">

                                    @error('post_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ $client->email ?? old('email') }}"
                                           required
                                           autocomplete="email">

                                    @error('email')
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
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone"
                                           value="{{ $client->phone ?? old('phone') }}"
                                           required
                                           autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Comment') }}</label>

                                <div class="col-md-6">
                                    <textarea id="comment" type="text"
                                              class="form-control @error('comment') is-invalid @enderror"
                                              name="comment">{{ $client->comment ?? old('comment') }}
                                    </textarea>
                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update client info') }}
                                    </button>


                                </div>
                            </div>
                        </form>
                        <form action="{{ route('client.destroy', $client->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="form-group row mb-0 mt-1">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger"
                                            onclick="if (!confirm('Are you sure ?')) event.preventDefault()">
                                        {{ __('Delete client') }}
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
