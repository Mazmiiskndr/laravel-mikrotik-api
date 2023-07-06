// Hide Modal
window.addEventListener('hide-modal', () => {
  $('#createNewAdmin').modal('hide');
  $('#updateAdminModal').modal('hide');
});
window.addEventListener('show-modal', () => {
  $('#updateAdminModal').modal('show');
});
// Function to show a modal based on a given id for UPDATE!
function showAdmin(id) {
  // Emit an event to show the modal with the given Livewire component id for UPDATE!
  Livewire.emit('getAdmin', id);
}

// Function to show a modal based on a given id for DELETE!
function confirmDeleteAdmin(id) {
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
      Livewire.emit('confirmAdmin', id);
    }
  });
}

let dataTable;

// Function to initialize the DataTable
function initializeDataTable() {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'username', name: 'username' },
    { data: 'fullname', name: 'fullname' },
    { data: 'group.name', name: 'group.name' },
    { data: 'email', name: 'email' },
    { data: 'status', name: 'status' }
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
