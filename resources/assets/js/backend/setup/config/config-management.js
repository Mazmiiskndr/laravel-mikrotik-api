// Function to show a modal based on a given name
function showModalByName(name) {
  let livewireComponentName = '';
  let resetFormFunctionName = '';
  switch (name) {
    // Router
    case 'edit_router':
      livewireComponentName = 'form.edit-router';
      resetFormFunctionName = 'resetForm';
      break;
    // Clients
    case 'clients':
      livewireComponentName = 'form.clients';
      resetFormFunctionName = 'resetForm';
      break;
    // Hotel Rooms
    case 'hotel_rooms':
      livewireComponentName = 'form.hotel_rooms';
      resetFormFunctionName = 'resetForm';
      break;
    // Users Data
    case 'users_data':
      livewireComponentName = 'form.users_data';
      break;
    // Social Plugins
    case 'social_plugins':
      livewireComponentName = 'form.social_plugins';
      break;
    // Ads
    case 'ads':
      livewireComponentName = 'form.ads';
      break;
    // Log Activity
    case 'edit_log_activity':
      livewireComponentName = 'form.log-activity';
      break;
    // Add more cases for other names here...
    default:
      livewireComponentName = 'form.edit-router';
      resetFormFunctionName = 'resetForm';
  }
  // Call the resetForm method before showing the modal
  if (resetFormFunctionName) {
    Livewire.emit(resetFormFunctionName);
  }

  // Emit an event to show the modal with the given Livewire component name
  Livewire.emit('showModal', livewireComponentName);
}

// Listen for the refreshDatatable event
Livewire.on('refreshDatatable', () => {
  $('#myTable').DataTable().ajax.reload(null, false);
});

let dataTable;

// Function to initialize the DataTable
function initializeDataTable() {
  dataTable = $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    order: [[0]],
    ajax: document.getElementById('myTable').dataset.route,
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
      { data: 'title', name: 'title', width: '50%' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
  });
}

// Initialize the DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  initializeDataTable();
});
Livewire.on('refreshDatatable', () => {
  setTimeout(() => {
    dataTable.ajax.reload(null, false);
  }, 200);
});
