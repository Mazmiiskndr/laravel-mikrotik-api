@extends('layouts/layoutMaster')
@section('title', 'Users Data')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To Users Data --}}
@if($permissions['isAllowedToUsersData'])
<h4 class="fw-bold py-3 mb-1">Users Data</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Users Data</h4>
            <div>
                {{-- /Start Button for Print --}}
                @if ($permissions['isAllowedToPrintUsersData'])
                <x-link-button color="facebook" icon="fas fa-lg fa-print" target="_blank">
                    &nbsp; Print Users Data
                </x-link-button>
                @endif
                {{-- /End Button for Print --}}

                {{-- /Start Button for Save To Excel --}}
                @if ($permissions['isAllowedToUsersDataCsv'])
                <x-button type="button" color="success">
                    <i class="tf-icons fas fa-file-excel ti-xs me-1"></i>&nbsp; Save to Excel
                </x-button>
                @endif
                {{-- /End Button for Save To Excel --}}

                {{-- /Start Button for Batch Delete --}}
                @if ($permissions['isAllowedToDeleteUsersData'])
                <x-button type="button" color="danger" onclick="confirmDeleteBatch()">
                    <i class="tf-icons fas fa-trash-alt ti-xs me-1"></i>&nbsp; Batch Delete
                </x-button>
                @endif
                {{-- /End Button for Batch Delete --}}
            </div>
        </div>
    </div>

    @if($permissions['isAllowedToUsersData'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        {{-- TODO: --}}
        @livewire('backend.client.users-data.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/backend/client/voucher/list-active-vouchers-management.js') }}"></script> --}}
    @endpush
</div>
@endif

@endsection
