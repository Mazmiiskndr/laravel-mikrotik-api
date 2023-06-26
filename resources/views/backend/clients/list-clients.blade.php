@extends('layouts/layoutMaster')
@section('title', 'List Clients')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Clients --}}
@if($permissions['isAllowedToListClients'])
<h4 class="fw-bold py-3 mb-1">List Clients</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Clients</h4>

            <div>
                {{-- /Start Button for Create New Client --}}
                @if ($permissions['isAllowedToAddNewClient'])
                <x-button type="button" color="facebook " data-bs-toggle="modal"
                    data-bs-target="#createNewClient">
                    <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Client
                </x-button>
                @endif
                {{-- /End Button for Create New Client --}}

                {{-- /Start Button for Batch Delete --}}
                @if ($permissions['isAllowedToBatchDeleteClients'])
                <x-button type="button" color="danger" onclick="confirmDeleteBatch()">
                    <i class="tf-icons fas fa-trash-alt ti-xs me-1"></i>&nbsp; Batch Delete
                </x-button>
                @endif
                {{-- /End Button for Batch Delete --}}
            </div>

        </div>
    </div>

    @if($permissions['isAllowedToListClients'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.list.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/client/client-management.js') }}"></script>
    @endpush
</div>
@endif

@if($permissions['isAllowedToAddNewClient'])
{{-- START FORM CREATE CLIENT --}}
@livewire('backend.client.list.create')
{{-- END FORM CREATE CLIENT --}}
@endif
@if($permissions['isAllowedToEditClient'])
{{-- START FORM EDIT CLIENT --}}
@livewire('backend.client.list.edit')
{{-- END FORM EDIT CLIENT --}}
@endif

@endsection
