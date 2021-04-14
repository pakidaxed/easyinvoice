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
                    <div class="card-header">{{ __('Notification list') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($notifications as $notification)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $notification->seen ?: 'font-weight-bold' }}">
                                    <div class="col-2 px-0">
                                        <span>{{ $notification->created_at }}</span>
                                    </div>
                                    <div class="col-10 px-0">
                                        {{ $notification->message }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link"
                                                         href="{{ $notifications->previousPageUrl() }}">&laquo;</a></li>
                                <li class="px-2 d-flex align-items-center">{{ $notifications->currentPage() }}
                                    of {{ $notifications->lastPage() }}</li>
                                <li class="page-item"><a class="page-link" href="{{ $notifications->nextPageUrl() }}">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

