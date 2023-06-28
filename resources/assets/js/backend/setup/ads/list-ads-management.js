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
const datePickers = ['timeToShow', 'timeToHide', 'timeToShowUpdate', 'timeToHideUpdate'];
datePickers.forEach(id => initializeFlatpickr(id, false));

// Hide Modal
window.addEventListener('hide-modal', () => {
  $('#createNewAd').modal('hide');
  $('#updateAdModal').modal('hide');
});
window.addEventListener('show-modal', () => {
  $('#updateAdModal').modal('show');
});

// Function to show a modal based on a given id for UPDATE!
function showAd(id) {
  // Emit an event to show the modal with the given Livewire component id for UPDATE!
  Livewire.emit('getAd', id);
}

// Function to show a modal based on a given id for DELETE!
function confirmDeleteAd(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'You will not be able to restore this data!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#7367f0',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.isConfirmed) {
      // Emit an event to show the modal with the given Livewire component id for DELETE!
      Livewire.emit('confirmAd', id);
    }
  });
}

let dataTable;

// Function to initialize the DataTable
function initializeDataTable() {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'image', name: 'image', width: '15%', orderable: false },
    { data: 'title', name: 'title' },
    { data: 'device_type', name: 'device_type' }
  ];

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
}

// Initialize the DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  initializeDataTable();
});
// Listen for the showCreateModal event
window.addEventListener('refreshDatatable', event => {
  dataTable.ajax.reload();
});
