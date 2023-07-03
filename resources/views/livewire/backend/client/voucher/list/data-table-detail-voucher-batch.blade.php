<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('detailVoucherBatch.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>S/N</th>
                <th>Username</th>
                <th>Password</th>
                <th>Total Time Used</th>
                <th>Valid Until</th>
                <th>Status</th>
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
            { data: 'serial_number', name: 'serial_number' },
            { data: 'username', name: 'username' },
            { data: 'password', name: 'password' },
            { data: 'first_use', name: 'first_use' },
            { data: 'valid_until', name: 'valid_until' },
            { data: 'status', name: 'status' }
        ];

        dataTable = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            order: [[0]], // order by the second column
            ajax: function(data, callback, settings) {
                // add the voucherBatchId to the data sent in the request
                data.voucherBatchId = @this.voucherBatchId;

                // make the AJAX request
                $.ajax({
                    url: document.getElementById('myTable').dataset.route,
                    data: data,
                    success: function(res) {
                        callback(res);
                    }
                });
            },
            columns: columns
        });
    });

    // Refresh DataTable when 'refreshDatatable' event is fired
    window.addEventListener('refreshDatatable', () => {
        dataTable.ajax.reload();
    });
</script>
@endpush
