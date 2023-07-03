@extends('layouts/layoutMaster')
@section('title', 'List of Vouchers in Batch')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

<h4 class="fw-bold py-3 mb-1">List of Vouchers in Batch</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Vouchers</h4>
            <div>

                {{-- TODO: PRINT THIS VOUCHER BATCH AND SAVE TO EXCEL --}}
                {{-- /Start Button for Print This Voucher Batch --}}
                <x-button type="button" color="primary btn-sm">
                    <i class="tf-icons fas fa-print ti-xs me-1"></i>&nbsp; Print This Voucher Batch
                </x-button>
                {{-- /End Button for Print This Voucher Batch --}}

                {{-- /Start Button for Export To Excel --}}
                <x-button type="button" color="success btn-sm">
                    <i class="tf-icons fas fa-file-excel ti-xs me-1"></i>&nbsp; Save to Excel
                </x-button>
                {{-- /End Button for Export To Excel --}}

            </div>
        </div>
    </div>

    {{-- Start List DataTable --}}
    <div class="card-body">
        {{-- TODO: --}}
        @livewire('backend.client.voucher.list.data-table-detail-voucher-batch',['voucherBatchId' => $voucherBatchId])
    </div>
    {{-- End List DataTable --}}

    @push('scripts')
    {{-- TODO: --}}
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    @endpush
</div>

@endsection
