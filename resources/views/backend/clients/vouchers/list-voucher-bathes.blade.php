@extends('layouts/layoutMaster')
@section('title', 'List Voucher Batches')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Voucher Batches --}}
@if($permissions['isAllowedToListVoucherBatches'])
<h4 class="fw-bold py-3 mb-1">List Voucher Batches</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Voucher Batches</h4>

            <div>
                {{-- /Start Button for Create New Voucher Batch --}}
                @if ($permissions['isAllowedToCreateVoucherBatch'])
                <x-button type="button" color="facebook btn-sm" data-bs-toggle="modal" data-bs-target="#createNewVoucherBatch">
                    <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Voucher Batch
                </x-button>
                @endif
                {{-- /End Button for Create New Voucher Batch --}}

                {{-- /Start Button for Batch Delete --}}
                @if ($permissions['isAllowedToDeleteVoucherBatches'])
                <x-button type="button" color="danger btn-sm" onclick="confirmDeleteVoucherBatches()">
                    <i class="tf-icons fas fa-trash-alt ti-xs me-1"></i>&nbsp; Batch Delete
                </x-button>
                @endif
                {{-- /End Button for Batch Delete --}}
            </div>

        </div>
    </div>

    @if($permissions['isAllowedToListVoucherBatches'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.voucher.list.data-table-voucher-batches')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/client/voucher/list-voucher-batches-management.js') }}"></script>
    @endpush
</div>
@endif

@if($permissions['isAllowedToCreateVoucherBatch'])
{{-- START FORM CREATE VOUCHER BATCH --}}
@livewire('backend.client.voucher.list.create')
{{-- END FORM CREATE VOUCHER BATCH --}}
@endif

@endsection
