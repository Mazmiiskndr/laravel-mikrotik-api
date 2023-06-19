<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Device Type</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script>
        // Function to show a modal based on a given id for UPDATE!
        function showAd(id) {
            // Emit an event to show the modal with the given Livewire component id for UPDATE!
            Livewire.emit('getAd', id);
        }

        // Function to show a modal based on a given id for DELETE!
        function confirmDeleteAd(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to restore this data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7367f0',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Emit an event to show the modal with the given Livewire component id for DELETE!
                    Livewire.emit('confirmAd', id);
                }
            })
        }

        let dataTable;

        // Function to initialize the DataTable
        function initializeDataTable() {
            dataTable = $('#myTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                ajax: "{{ route('ads.getDataTable') }}", // This route should point to the getDatatables method
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'10px', orderable: false, searchable: false},
                    {data: 'image', name: 'image', width:'15%', orderable: false},
                    {data: 'title', name: 'title'},
                    {data: 'device_type', name: 'device_type'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        }

        // Initialize the DataTable when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            initializeDataTable();
        });
        // Listen for the showCreateModal event
        window.addEventListener('refreshDatatable', event =>{
            dataTable.ajax.reload();
        });
    </script>
    @endpush
</div>