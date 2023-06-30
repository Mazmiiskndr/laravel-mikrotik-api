<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('activeVouchers.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Service</th>
                <th>Valid Until</th>
                <th>Created By</th>
                <th>Created Date</th>
                <th>Voucher Batch</th>
            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    // Initialize DataTable when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        var columns = [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
            { data: 'service_name', name: 'service_name' },
            { data: 'valid_until', name: 'valid_until' },
            { data: 'created_by', name: 'created_by' },
            { data: 'create_date', name: 'create_date' },
            { data: 'voucher_batch_id', name: 'voucher_batch_id', className: 'text-center' }
        ];

        dataTable = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            order: [[0]], // order by the second column
            ajax: document.getElementById('myTable').dataset.route,
            columns: columns
        });
    });

    // Refresh DataTable when 'refreshDatatable' event is fired
    window.addEventListener('refreshDatatable', () => {
        dataTable.ajax.reload();
    });
</script>
@endpush
