// Initialize DataTable when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
  var tableElement = document.querySelector('.table');
  var voucherBatchId = tableElement.dataset.voucherBatchId;
  var columns = [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '10px', orderable: false, searchable: false },
    { data: 'serial_number', name: 'serial_number' },
    { data: 'username', name: 'username' },
    { data: 'first_use', name: 'first_use' },
    { data: 'valid_until', name: 'valid_until' },
    { data: 'status', name: 'status' }
  ];

  // If the data-voucher-batch-type attribute is 'with_password', include the password column
  if (tableElement.dataset.voucherBatchType === 'with_password') {
    columns.splice(3, 0, { data: 'password', name: 'password' });
  }
  dataTable = $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    order: [[0]], // order by the second column
    ajax: function (data, callback, settings) {
      // add the voucherBatchId to the data sent in the request
      data.voucherBatchId = voucherBatchId;

      // make the AJAX request
      $.ajax({
        url: document.getElementById('myTable').dataset.route,
        data: data,
        success: function (res) {
          callback(res);
        }
      });
    },
    columns: columns
  });
});

// Refresh DataTable when 'refreshDatatable' event is fired
window.addEventListener('refreshDatatable', () => {
  dataTable.ajax.reload();
});
