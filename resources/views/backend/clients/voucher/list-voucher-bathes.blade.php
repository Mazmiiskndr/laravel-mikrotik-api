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
                {{-- TODO: --}}
                {{-- /Start Button for Create New Voucher Batch --}}
                @if ($permissions['isAllowedToCreateVoucherBatch'])
                <x-button type="button" color="facebook btn-sm" data-bs-toggle="modal" data-bs-target="#createNewVoucherBatch">
                    <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Voucher Batch
                </x-button>
                @endif
                {{-- /End Button for Create New Voucher Batch --}}

                {{-- TODO: --}}
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
        @livewire('backend.client.voucher.list.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    {{-- TODO: --}}
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/backend/client/client-management.js') }}"></script> --}}
    <script>
        // Event listener for hiding modals
        window.addEventListener('hide-modal', () => {
            ['createNewVoucherBatch'].forEach(id => $(`#${id}`).modal('hide'));
        });

        // Get the 'select all' checkbox
        let selectAllCheckbox = document.getElementById('select-all-checkbox');

        // Only add the event listener if the checkbox actually exists
        if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('click', function (event) {
                // Get all the checkboxes with the class 'voucherBatch-checkbox'
                let checkboxes = document.getElementsByClassName('voucherBatch-checkbox');

                // Set their checked property to the same as the 'select all' checkbox
                Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
            });
        }

        // Function to confirm Batch Delete
        function confirmDeleteVoucherBatches() {
            // Get all checked voucherBatch_uid
            let voucherBatchUids = Array.from(document.querySelectorAll('.voucherBatch-checkbox:checked')).map(el => el.value);

            if (voucherBatchUids.length > 0) {
                showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
                    // Emit an event to delete the checked voucher Batches
                    Livewire.emit('deleteBatch', voucherBatchUids);
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'You must select at least one voucher batch to delete!' });
            }
        }

        // Function to show a modal for UPDATE!
        function showVoucherBatch(uid) {
            Livewire.emit('getVoucherBatch', uid);
        }

        // Function to show a modal for DELETE!
        function confirmDeleteVoucherBatch(uid) {
            showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
                Livewire.emit('confirmVoucherBatch', uid);
            });
        }
    </script>
    @endpush
</div>
@endif

@if($permissions['isAllowedToCreateVoucherBatch'])
{{-- START FORM CREATE VOUCHER BATCH --}}
@livewire('backend.client.voucher.list.create')
{{-- END FORM CREATE VOUCHER BATCH --}}
@endif

@endsection
