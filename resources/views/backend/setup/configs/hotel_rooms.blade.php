@extends('layouts/layoutMaster')
@section('title', 'List Configs')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To Config Hotel Rooms --}}
@if($permissions['isAllowedToConfigHotelRooms'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Configs </span>/ Hotel Rooms</h4>

<!-- DataTable with Buttons -->
<div class="row">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Add New Service</h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('backend.setup.config.hotel-room.add-service')
            </div>
        </div>
    </div>

    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Table Registered Service</h4>
                </div>
            </div>
            <div class="card-body">
                @livewire('backend.setup.config.hotel-room.data-table')
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/backend/setup/config/hotel-room/hotel-room-management.js') }}"></script>
@endpush

@endif

@endsection
