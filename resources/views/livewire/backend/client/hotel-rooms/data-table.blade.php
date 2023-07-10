@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_hotel_room');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('hotelRooms.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Room Number</th>
                <th>Name</th>
                <th>Password</th>
                <th>Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
    <script>
        var canEdit = @json($canEdit);
    </script>
@endpush
