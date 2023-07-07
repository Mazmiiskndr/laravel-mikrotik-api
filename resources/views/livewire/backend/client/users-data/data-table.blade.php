@php
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_users_data');
$printCsv = App\Helpers\AccessControlHelper::isAllowedToPerformAction('users_data_csv');

@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('usersData.getDataTable') }}">
        <thead>
            <tr>
                @if($canDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Guest Name</th>
                <th>Email Address</th>
                <th>Room Number</th>
                <th>Input Date</th>
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
    var printCsv = @json($printCsv);

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

    // Event listener for hiding modals
    window.addEventListener('hide-modal', () => {
        ['createNewUserData', 'updateUserDataModal'].forEach(id => $(`#${id}`).modal('hide'));
    });

    // Event listener for showing modals
    window.addEventListener('show-modal', () => {
        $('#updateUserDataModal').modal('show');
    });

    // Get the 'select all' checkbox
    let selectAllCheckbox = document.getElementById('select-all-checkbox');

    // Only add the event listener if the checkbox actually exists
    if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('click', function (event) {
        // Get all the checkboxes with the class 'users-data-checkbox'
        let checkboxes = document.getElementsByClassName('users-data-checkbox');

        // Set their checked property to the same as the 'select all' checkbox
        Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
    });
    }

    // Initialize DataTable when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        var columns = [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'room_number', name: 'room_number' },
            { data: 'date', name: 'date' },
        ];

        if (canDelete) {
            columns.unshift({
                data: 'id',
                render: function (data, type, row) {
                    return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input users-data-checkbox' value='${data}'>`;
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

    // Function to confirm Batch Delete
    function confirmDeleteBatch() {
    // Get all checked userDataId
    let userDataIds = Array.from(document.querySelectorAll('.users-data-checkbox:checked')).map(el => el.value);

    if (userDataIds.length > 0) {
            showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
                // Emit an event to delete the checked users-data
                Livewire.emit('confirmUserDataBatch', userDataIds);
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'You must select at least one user to delete!' });
        }
    }

    // Function to show a modal for UPDATE!
    function showUserData(userDataId) {
        Livewire.emit('getUserData', userDataId);
    }
    if (canDelete) {
        // Function to show a modal for DELETE!
        function confirmDeleteUsersData(userDataId) {
            showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
                Livewire.emit('confirmUserData', userDataId);
            });
        }
    }
    if (printPdf) {
        // Function to print PDF
        function saveToExcel() {
            Livewire.emit('saveToPdf');
        }
    }
</script>
@endpush
