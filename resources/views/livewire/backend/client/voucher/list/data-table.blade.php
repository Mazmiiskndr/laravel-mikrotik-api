@php
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_client');
$canBatchDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('batch_delete_clients');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('voucherBatches.getDataTable') }}">
        <thead>
            <tr>
                @if($canBatchDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Created Date</th>
                <th>Service Name</th>
                <th>Quantity</th>
                <th>Created By</th>
                <th>Note</th>
                @if($canDelete)
                <th>Action</th>
                @endif

            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    var canDelete = @json($canDelete);
    var canBatchDelete = @json($canBatchDelete);


    // Helper function to show a Swal dialog
    function showSwalDialog(title, text, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7367f0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    // Initialize DataTable when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        var columns = [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
            { data: 'create_date', name: 'create_date' },
            { data: 'service_name', name: 'service_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'created_by', name: 'created_by' },
            { data: 'note', name: 'note' }
        ];

        if (canBatchDelete) {
            columns.unshift({
                data: 'voucher_batches_uid',
                render: function (data, type, row) {
                    return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input client-checkbox' value='${data}'>`;
                },
                orderable: false,
                searchable: false,
                width: '15px'
            });
        }
        if (canDelete) {
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
    });

    // Refresh DataTable when 'refreshDatatable' event is fired
    window.addEventListener('refreshDatatable', () => {
        dataTable.ajax.reload();
    });
</script>
@endpush
