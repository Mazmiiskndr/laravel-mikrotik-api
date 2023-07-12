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
      {
        data: 'radacctid',
        render: function (data, type, row) {
          return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input users-checkbox'
                            value='${data}'>`;
        },
        orderable: false,
        searchable: false,
        width: '15px'
      },
      { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
      { data: 'username', name: 'username' },
      { data: 'firstuse', name: 'firstuse' },
      { data: 'sessionstart', name: 'sessionstart' },
      { data: 'onlinetime', name: 'onlinetime' },
      { data: 'ipaddress', name: 'ipaddress' },
      { data: 'macaddress', name: 'macaddress' }
    ]
  });
}

// Get the 'select all' checkbox
let selectAllCheckbox = document.getElementById('select-all-checkbox');

// Only add the event listener if the checkbox actually exists
if (selectAllCheckbox) {
  selectAllCheckbox.addEventListener('click', function (event) {
    // Get all the checkboxes with the class 'users-checkbox'
    let checkboxes = document.getElementsByClassName('users-checkbox');

    // Set their checked property to the same as the 'select all' checkbox
    Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
  });
}

function collectCheckedIds() {
  // Get all checked radAcctId
  return Array.from(document.querySelectorAll('.users-checkbox:checked')).map(el => el.value);
}

function confirmAction(action) {
  let radAcctIds = collectCheckedIds();
  let actionTitles = {
    disconnect: 'disconnect',
    block: 'block'
  };

  if (radAcctIds.length > 0) {
    showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
      // Emit an event to perform the action on the checked users
      Livewire.emit(`${action}Batch`, radAcctIds);
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: `You must select at least one user to ${actionTitles[action]}!`
    });
  }
}

// Initialize the DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  initializeDataTable();
});

// Listen for the showCreateModal event
window.addEventListener('refreshDatatable', event => {
  dataTable.ajax.reload();
});
