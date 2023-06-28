@extends('layouts/layoutMaster')
@section('title', 'List Admins')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Admins --}}
@if($permissions['isAllowedToListAdmins'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Administrators </span>/ List</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Admins</h4>

            @if ($permissions['isAllowedToAddNewAdmin'])
            <x-button type="button" color="facebook" data-bs-toggle="modal" data-bs-target="#createNewAdmin">
                <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Admin
            </x-button>
            {{-- /Create Button for Add New Admin --}}
            @endif
        </div>
    </div>

    @if($permissions['isAllowedToListAdmins'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.setup.administrator.admin.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/setup/administrator/admin/admin-management.js') }}"></script>
    @endpush
</div>
@endif

@if($permissions['isAllowedToAddNewAdmin'])
{{-- START FORM CREATE ADMIN --}}
@livewire('backend.setup.administrator.admin.create')
{{-- END FORM CREATE ADMIN --}}
@endif
@if($permissions['isAllowedToEditAdmin'])
{{-- START FORM EDIT ADMIN --}}
@livewire('backend.setup.administrator.admin.edit')
{{-- END FORM EDIT ADMIN --}}
@endif

@endsection
