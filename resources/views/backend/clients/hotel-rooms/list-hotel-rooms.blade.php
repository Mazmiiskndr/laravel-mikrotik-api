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
            <div>
                {{-- /Start Button for Print --}}
                @if ($permissions['isAllowedToPrintHotelRooms'])
                <x-link-button color="facebook" icon="fas fa-lg fa-file-pdf" route="backend.clients.hotel-rooms.print" target="_blank">
                    &nbsp; Print Hotel Rooms
                </x-link-button>
                @endif
                {{-- /End Button for Print --}}

                {{-- /Start Button for Save To Excel --}}
                @if ($permissions['isAllowedToHotelRoomsCsv'])
                <x-button type="button" color="success" onclick="saveToExcel()">
                    <i class="tf-icons fas fa-file-excel ti-xs me-1"></i>&nbsp; Save to Excel
                </x-button>
                @endif
                {{-- /End Button for Save To Excel --}}
            </div>
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
