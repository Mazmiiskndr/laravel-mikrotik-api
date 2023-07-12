@extends('layouts/layoutMaster')
@section('title', 'List Bypassed Macs')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Bypassed Macs --}}
@if($permissions['isAllowedToListMacs'])
<h4 class="fw-bold py-3 mb-1">List Bypassed Macs</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Bypassed Macs</h4>

            <div>
                {{-- /Start Button for Create New Mac --}}
                @if ($permissions['isAllowedToAddMac'])
                <x-button type="button" color="facebook btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createNewMac">
                    <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Mac
                </x-button>
                @endif
                {{-- /End Button for Create New Mac --}}

                {{-- /Start Button for Batch Delete --}}
                @if ($permissions['isAllowedToBatchDeleteMacs'])
                <x-button type="button" color="danger btn-sm" onclick="confirmDeleteBatch()">
                    <i class="tf-icons fas fa-trash-alt ti-xs me-1"></i>&nbsp; Batch Delete
                </x-button>
                @endif
                {{-- /End Button for Batch Delete --}}
            </div>

        </div>
    </div>

    @if($permissions['isAllowedToListMacs'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.bypass-macs.data-table-bypassed-macs')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/client/bypass-mac/bypass-mac-management.js') }}"></script>
    @endpush
</div>
@endif

{{-- TODO: --}}
@if($permissions['isAllowedToAddMac'])
{{-- START FORM CREATE MAC --}}
@livewire('backend.client.bypass-macs.create',['defaulStatus' => 'bypassed'])
{{-- END FORM CREATE MAC --}}
@endif
@if($permissions['isAllowedToEditMac'])
{{-- START FORM EDIT MAC --}}
@livewire('backend.client.bypass-macs.edit',['defaulStatus' => 'bypassed'])
{{-- END FORM EDIT MAC --}}
@endif

@endsection
