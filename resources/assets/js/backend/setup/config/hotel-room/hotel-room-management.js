// Function to show a modal based on a given id for DELETE!
function confirmDeleteService(id) {
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
      Livewire.emit('confirmService', id);
    }
  });
}

let dataTable;

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
      { data: 'service_name', name: 'service_name' },
      { data: 'cron_type', name: 'cron_type' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
  });
}

document.addEventListener('DOMContentLoaded', function () {
  initializeDataTable();
});

// Listen for the showCreateModal event
window.addEventListener('refreshDatatable', event => {
  dataTable.ajax.reload();
});
