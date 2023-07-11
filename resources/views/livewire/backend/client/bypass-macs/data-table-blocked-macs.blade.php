@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_mac');
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_mac');
$canBatchDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('batch_delete_macs');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('blockedMacs.getDataTable') }}">
        <thead>
            <tr>
                @if($canBatchDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Mac Address</th>
                <th>Status</th>
                <th>Description</th>
                <th>Date</th>
                @if($canEdit || $canDelete)
                <th>Action</th>
                @endif

            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    var canEdit = @json($canEdit);
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


    // Get the 'select all' checkbox
    let selectAllCheckbox = document.getElementById('select-all-checkbox');

    // Only add the event listener if the checkbox actually exists
    if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('click', function (event) {
        // Get all the checkboxes with the class 'mac-checkbox'
        let checkboxes = document.getElementsByClassName('mac-checkbox');

        // Set their checked property to the same as the 'select all' checkbox
        Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
    });
    }

    // Initialize DataTable when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
    var columns = [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
        { data: 'mac_address', name: 'mac_address' },
        { data: 'status', name: 'status' },
        { data: 'description', name: 'description' },
        { data: 'date', name: 'date' },
    ];

    if (canBatchDelete) {
        columns.unshift({
            data: 'id',
                render: function (data, type, row) {
                    return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input mac-checkbox' value='${data}'>`;
                },
            orderable: false,
            searchable: false,
            width: '15px'
        });
    }
    if (canEdit || canDelete) {
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

    // Function to confirm Batch Delete
    function confirmDeleteBatch() {
        // Get all checked bypassMacId
        let bypassMacIds = Array.from(document.querySelectorAll('.mac-checkbox:checked')).map(el => el.value);

        if (bypassMacIds.length > 0) {
            showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
            // Emit an event to delete the checked macs
            Livewire.emit('deleteBatch', bypassMacIds);
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'You must select at least one mac to delete!' });
        }
    }

    // Function to show a modal for UPDATE!
    function showMac(bypassMacId) {
        Livewire.emit('getBypassMac', bypassMacId);
    }

    // Function to show a modal for DELETE!
    function confirmDeleteMac(bypassMacId) {
        showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
            Livewire.emit('confirmMac', bypassMacId);
        });
    }
</script>
@endpush
