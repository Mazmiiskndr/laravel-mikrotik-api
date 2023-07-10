@extends('layouts/layoutMaster')
@section('title', 'Hotel Rooms')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To Hotel Rooms --}}
@if($permissions['isAllowedToHotelRooms'])
<h4 class="fw-bold py-3 mb-1">Hotel Rooms</h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header" style="margin-bottom: -15px">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Hotel Rooms</h4>
        </div>
    </div>

    @if($permissions['isAllowedToHotelRooms'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.client.hotel-rooms.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

</div>

@if($permissions['isAllowedToEditHotelRoom'])
{{-- Start Edit Hotel Room --}}
<div class="card-body">
    @livewire('backend.client.hotel-rooms.edit')
</div>
{{-- End Edit Hotel Room --}}
@endif

@push('scripts')
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/backend/client/hotel-room/hotel-room-management.js') }}"></script>
@endpush

@endif

@endsection
