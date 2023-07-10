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
        // Hide Modal


        let dataTable;

        // Function to initialize the DataTable
        function initializeDataTable() {
        var columns = [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
            { data: 'room_number', name: 'room_number' },
            { data: 'name', name: 'name' },
            { data: 'password', name: 'password' },
            { data: 'service_name', name: 'service_name' },
            { data: 'status', name: 'status' },
        ];

        // TODO: EDIT HOTEL ROOMS
        if (canEdit) {
            columns.push({ data: 'action', name: 'action', orderable: false, searchable: false });
        }

        dataTable = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            order: [[0]], // order by the second column
            ajax: document.getElementById('myTable').dataset.route,
            columns: columns
        });
        }

        // Initialize the DataTable when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            initializeDataTable();
        });
        // Listen for the showCreateModal event
        window.addEventListener('refreshDatatable', event => {
            dataTable.ajax.reload();
        });

    </script>
@endpush
