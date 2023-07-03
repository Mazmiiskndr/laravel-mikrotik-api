// Event listener for hiding modals
window.addEventListener('hide-modal', () => {
  ['createNewVoucherBatch'].forEach(id => $(`#${id}`).modal('hide'));
});

// Get the 'select all' checkbox
let selectAllCheckbox = document.getElementById('select-all-checkbox');

// Only add the event listener if the checkbox actually exists
if (selectAllCheckbox) {
  selectAllCheckbox.addEventListener('click', function (event) {
    // Get all the checkboxes with the class 'voucherBatch-checkbox'
    let checkboxes = document.getElementsByClassName('voucherBatch-checkbox');

    // Set their checked property to the same as the 'select all' checkbox
    Array.from(checkboxes).forEach(checkbox => (checkbox.checked = event.target.checked));
  });
}

// Function to confirm Batch Delete
function confirmDeleteVoucherBatches() {
  // Get all checked voucherBatch_uid
  let voucherBatchIds = Array.from(document.querySelectorAll('.voucherBatch-checkbox:checked')).map(el => el.value);

  if (voucherBatchIds.length > 0) {
    showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
      // Emit an event to delete the checked voucher Batches
      Livewire.emit('deleteBatches', voucherBatchIds);
    });
  } else {
    Swal.fire({ icon: 'error', title: 'Oops...', text: 'You must select at least one voucher batch to delete!' });
  }
}

// Function to show a modal for UPDATE!
function showVoucherBatch(id) {
  Livewire.emit('getVoucherBatch', id);
}

// Function to show a modal for DELETE!
function confirmDeleteVoucherBatch(id) {
  showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
    Livewire.emit('confirmVoucherBatch', id);
  });
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

// Initialize DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'service_name', name: 'service_name' },
    { data: 'quantity', name: 'quantity' },
    { data: 'note', name: 'note' },
    { data: 'created_by', name: 'created_by' },
    { data: 'create_date', name: 'create_date' }
  ];

  if (canBatchDelete) {
    columns.unshift({
      data: 'id',
      render: function (data, type, row) {
        return `<input type='checkbox' style='border: 1px solid #8f8f8f;' class='form-check-input voucherBatch-checkbox' value='${data}'>`;
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
