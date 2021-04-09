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
                    <div class="card-header">{{ __('Clients list') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <form>
                                <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search by company name">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary">Search</button>
                                    </div>
                                </div>
                                </form>
                            </li>
                            @foreach($clients as $client)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div class="col-4 px-0">
                                        <a href="{{ route('client.edit', $client->id) }}">{{ $client->name }}</a>
                                    </div>
                                    <div class="col-5 px-0">
                                        <span>{{ $client->comment }}</span>
                                    </div>
                                    <div class="col-1 px-0">
                                        <span>{{ $client->city->name }}</span>
                                    </div>
                                    <div class="col d-flex justify-content-end px-0">
                                        <a href="{{ route('invoice.create', ['client' => $client->id]) }}">
                                            <button class="btn-sm btn-warning mr-1">{{ __('New invoice') }}</button>
                                        </a>
                                        <form class="d-inline" action="{{ route('client.destroy', $client->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger"
                                                    onclick="if (!confirm('Are you sure ?')) event.preventDefault()">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="{{ $clients->previousPageUrl() }}">&laquo;</a></li>
                                <li class="px-2 d-flex align-items-center">{{ $clients->currentPage() }} of {{ $clients->lastPage() }}</li>
                                <li class="page-item"><a class="page-link" href="{{ $clients->nextPageUrl() }}">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

