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

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    @endpush
</div>
@endif

@endsection
