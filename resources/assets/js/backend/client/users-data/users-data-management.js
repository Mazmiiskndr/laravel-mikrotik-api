if (findUsersData) {
  // Helper function to initialize a flatpickr instance with common settings
  function initializeFlatpickr(elementId, isDateTime = true) {
    const element = document.querySelector(`#${elementId}`);
    // Ensure the element actually exists in the document
    if (element) {
      const config = isDateTime ? { enableTime: true, dateFormat: 'Y-m-d H:i' } : { monthSelectorType: 'static' };
      return element.flatpickr(config);
    }
  }

  // Initialize flatpickr instances
  const datePickers = ['fromDate', 'toDate'];
  datePickers.forEach(id => initializeFlatpickr(id, false));
}

let fromDate = null;
let toDate = null;

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
    { data: 'date', name: 'date' }
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
    ajax: {
      url: document.getElementById('myTable').dataset.route,
      data: function (d) {
        d.fromDate = fromDate;
        d.toDate = toDate;
      }
    },
    columns: columns
  });
});

// Refresh DataTable when 'refreshDatatable' event is fired
window.addEventListener('dateUpdated', event => {
  fromDate = event.detail.fromDate;
  toDate = event.detail.toDate;
  dataTable.ajax.reload();
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
