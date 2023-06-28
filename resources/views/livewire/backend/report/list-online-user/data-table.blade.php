<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('report.getDataTableListOnlineUsers') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>First Use</th>
                <th>Session Start</th>
                <th>Online Time</th>
                <th>IP Address</th>
                <th>MAC Address</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script>
    // Function to initialize the DataTable
    function initializeDataTable() {
        dataTable = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            order: [[0]], // order by the second column
            ajax: document.getElementById('myTable').dataset.route,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
                { data: 'username', name: 'username' },
                { data: 'firstuse', name: 'firstuse' },
                { data: 'sessionstart', name: 'sessionstart' },
                { data: 'onlinetime', name: 'onlinetime' },
                { data: 'ipaddress', name: 'ipaddress' },
                { data: 'macaddress', name: 'macaddress' },
            ]
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
