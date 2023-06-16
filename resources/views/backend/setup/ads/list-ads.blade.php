@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')
@section('title', 'List Ads')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Ads --}}
@if($permissions['isAllowedToListAds'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Ads </span>/ List</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Ads</h4>

            @if ($permissions['isAllowedToAddAd'])
            <x-button type="button" color="facebook" data-bs-toggle="modal" data-bs-target="#createNewAdmin">
                <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add new Ad
            </x-button>
            {{-- /Create Button for Add New Admin --}}
            @endif
        </div>
    </div>

    @if($permissions['isAllowedToListAds'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        {{-- TODO: --}}
        {{-- @livewire('backend.setup.administrator.admin.data-table') --}}
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    {{-- TODO: --}}
    {{-- <script>
        // Hide Modal
        window.addEventListener('hide-modal', () => {
            $('#createNewAdmin').modal('hide');
            $('#updateAdminModal').modal('hide');
        });
        window.addEventListener('show-modal', () => {
            $('#updateAdminModal').modal('show');
        });
    </script> --}}
    @endpush
</div>
@endif

{{-- TODO: --}}
@if($permissions['isAllowedToEditAd'])
{{-- TODO: --}}
{{-- @livewire('backend.setup.administrator.admin.create') --}}
@endif
@if($permissions['isAllowedToDeleteAd'])
{{-- TODO: --}}
{{-- @livewire('backend.setup.administrator.admin.edit') --}}
@endif

@endsection
