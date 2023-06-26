// Helper function to initialize a flatpickr instance with common settings
function initializeFlatpickr(elementId, isDateTime = true) {
  const element = document.querySelector(`#${elementId}`);
  // Ensure the element actually exists in the document
  if (element) {
    const config = isDateTime ? { enableTime: true, dateFormat: 'Y-m-d H:i' } : { monthSelectorType: 'static' };
    return element.flatpickr(config);
  }
}

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

// Initialize flatpickr instances
const datetimePickers = ['validFrom', 'validTo', 'validFromUpdate', 'validToUpdate'];
const datePickers = ['dateOfBirth', 'dateOfBirthUpdate'];

datetimePickers.forEach(id => initializeFlatpickr(id));
datePickers.forEach(id => initializeFlatpickr(id, false));

// Event listener for hiding modals
window.addEventListener('hide-modal', () => {
  ['createNewClient', 'updateClientModal'].forEach(id => $(`#${id}`).modal('hide'));
});

// Event listener for showing modals
window.addEventListener('show-modal', () => {
  $('#updateClientModal').modal('show');
});

// Get the 'select all' checkbox
let selectAllCheckbox = document.getElementById('select-all-checkbox');

// Only add the event listener if the checkbox actually exists
if (selectAllCheckbox) {
  selectAllCheckbox.addEventListener('click', function (event) {
    // Get all the checkboxes with the class 'client-checkbox'
    let checkboxes = document.getElementsByClassName('client-checkbox');

    // Set their checked property to the same as the 'select all' checkbox
    Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
  });
}

// Initialize DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'username', name: 'username' },
    { data: 'service_name', name: 'service_name' }
  ];

  if (canBatchDelete) {
    columns.unshift({
      data: 'client_uid',
      render: function (data, type, row) {
        return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input client-checkbox' value='${data}'>`;
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
  // Get all checked client_uid
  let clientUids = Array.from(document.querySelectorAll('.client-checkbox:checked')).map(el => el.value);

  if (clientUids.length > 0) {
    showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
      // Emit an event to delete the checked clients
      Livewire.emit('deleteBatch', clientUids);
    });
  } else {
    Swal.fire({ icon: 'error', title: 'Oops...', text: 'You must select at least one client to delete!' });
  }
}

// Function to show a modal for UPDATE!
function showClient(uid) {
  Livewire.emit('getClient', uid);
}

// Function to show a modal for DELETE!
function confirmDeleteClient(uid) {
  showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
    Livewire.emit('confirmClient', uid);
  });
}
