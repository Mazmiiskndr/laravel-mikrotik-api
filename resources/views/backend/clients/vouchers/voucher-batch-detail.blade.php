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

                {{-- /Start Button for Print This Voucher Batch --}}
                <x-link-button color="danger" route="backend.clients.voucher.voucher-batch-detail.print" identity="{{ $voucherBatchId }}" icon="fas fa-lg fa-file-pdf" target="_blank">
                    &nbsp; Print Vouchers
                </x-link-button>
                {{-- /End Button for Print This Voucher Batch --}}

                {{-- /Start Button for Export To Excel --}}
                @livewire('backend.client.voucher.list.save-to-excel',['voucherBatchId' => $voucherBatchId])
                {{-- /End Button for Export To Excel --}}

            </div>
        </div>
    </div>

    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.voucher.list.data-table-detail-voucher-batch',['voucherBatchId' => $voucherBatchId])
    </div>
    {{-- End List DataTable --}}

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/client/voucher/voucher-batch-detail-management.js') }}"></script>
    @endpush
</div>

@endsection
