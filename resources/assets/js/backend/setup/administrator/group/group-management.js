let dataTable;

// Function to initialize the DataTable
function initializeDataTable() {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'name', name: 'name' }
  ];

  if (canEdit) {
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
