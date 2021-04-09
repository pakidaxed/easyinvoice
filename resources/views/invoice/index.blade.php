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
                    <div class="card-header">{{ __('Invoices list') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center">
                                <div class="col-2 px-0">
                                    <a href="{{ route('invoice.index') }}" class="font-weight-bold text-decoration-none">
                                        Invoice number <span>🔻</span></a>
                                </div>
                                <div class="col-3 px-0">
                                    <a href="{{ route('invoice.index', 'filter=client_id') }}" class="font-weight-bold text-decoration-none">
                                        Client name<span>🔻</span></a>
                                </div>
                                <div class="col-3 px-0">
                                    <a href="{{ route('invoice.index', 'filter=created_at') }}" class="font-weight-bold text-decoration-none">
                                        Date created<span>🔻</span></a>
                                </div>
                                <div class="col-2 px-0">
                                    <a href="{{ route('invoice.index', 'filter=sum_excl_tax') }}" class="font-weight-bold text-decoration-none">
                                        Sum (excl. TAX)<span>🔻</span></a>
                                </div>
                                <div class="col d-flex justify-content-end px-0">
                                    <span class="font-weight-bold text-decoration-none text-primary">Actions</span>
                                </div>
                            </li>
                            @foreach($invoices as $invoice)
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
                                    <div class="col d-flex justify-content-end px-0">
                                        <div class="actions d-flex">
                                            @if(!$invoice->paid)
                                                <form action="{{ route('invoice.isPaid', $invoice->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button
                                                        onclick="if (!confirm('Are you sure ?')) event.preventDefault()"
                                                        class="btn-sm btn-success mr-1">{{ __('Confirm') }}</button>
                                                </form>
                                            @endif
                                            <form class="d-inline" action="{{ route('invoice.destroy', $invoice->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm btn-danger"
                                                        onclick="if (!confirm('Are you sure ?')) event.preventDefault()">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="{{ $invoices->previousPageUrl() }}">&laquo;</a></li>
                                <li class="px-2 d-flex align-items-center">{{ $invoices->currentPage() }} of {{ $invoices->lastPage() }}</li>
                                <li class="page-item"><a class="page-link" href="{{ $invoices->nextPageUrl() }}">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

