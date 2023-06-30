@extends('layouts/layoutMaster')
@section('title', 'List Active Vouchers')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To List Active Vouchers --}}
@if($permissions['isAllowedToListActiveVouchers'])
<h4 class="fw-bold py-3 mb-1">List Active Vouchers</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Active Vouchers</h4>
        </div>
    </div>

    @if($permissions['isAllowedToListActiveVouchers'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        {{-- TODO:  --}}
        @livewire('backend.client.voucher.list.data-table-active-vouchers')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    {{-- TODO: --}}
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    @endpush
</div>
@endif

@endsection
