// Function to send save to excel
function saveToExcel() {
  // Emit an event to print Excel
  Livewire.emit('saveToExcel');
}
// Function to show a modal based on a given id for UPDATE!
function showHotelRoom(id) {
  // Emit an event to show the modal with the given Livewire component id for UPDATE!
  Livewire.emit('getHotelRoomById', id);
}
// Event listener for hiding modals
window.addEventListener('hide-modal', () => {
  ['updateHotelRoomModal'].forEach(id => $(`#${id}`).modal('hide'));
});
// Event listener for showing modals
window.addEventListener('show-modal', () => {
  $('#updateHotelRoomModal').modal('show');
});
// Hide Modal
let dataTable;

// Function to initialize the DataTable
function initializeDataTable() {
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'room_number', name: 'room_number' },
    { data: 'name', name: 'name' },
    { data: 'password', name: 'password' },
    { data: 'service_name', name: 'service_name' },
    { data: 'status', name: 'status' }
  ];

  // TODO: EDIT HOTEL ROOMS
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
