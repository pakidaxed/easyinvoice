@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('BUSI PAKEISTAS :)!') }}

                        <p>{{ $joke ?? 'ner' }}</p>
                        <div class="div">
                            <total-amount></total-amount>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
