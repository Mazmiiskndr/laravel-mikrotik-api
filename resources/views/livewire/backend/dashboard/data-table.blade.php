

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">DHCP Server Leases Data</h4>
            {{-- /Create Button for Add New Admin --}}
        </div>
    </div>

    {{-- Start List DataTable --}}
    <div class="card-body">
        <div wire:ignore class="table">
            <table class="table table-hover table-responsive display" id="leasesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>IP Address</th>
                        <th>Mac Address</th>
                        <th>Host Name</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    {{-- End List DataTable --}}
    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script>
        let dataTable; // DataTable instance
        let leasesDataEmpty = false; // Flag to indicate if leases data is empty

        /**
         * Initialize DataTable instance.
         * If the leases data is empty, abort initialization.
         */
        function initializeDataTable() {
            if (leasesDataEmpty) {
                return;
            }
            // Initialize DataTable when the DOM is ready
            dataTable = $('#leasesTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                "retrieve": true,
                "order": [[ 1, "asc" ]], // order by the second column (IP Address)
                ajax: "{{ route('leasesData.getDataTable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'10px', orderable: false, searchable: false},
                    {data: 'address', name: 'address'},
                    {data: 'mac-address', name: 'mac-address'},
                    {data: 'host-name', name: 'host-name'}
                ]
            });
        }

        // Initialize DataTable when the DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            initializeDataTable();
        });

        // On 'refreshDatatable' event, reload DataTable or initialize it if it hasn't been initialized
        window.addEventListener('refreshDatatable', event => {
            if (dataTable) {
                dataTable.ajax.reload();
            } else {
                initializeDataTable();
            }
        });

        // On 'leasesDataEmpty' event, set the leasesDataEmpty flag to true
        window.livewire.on('leasesDataEmpty', () => {
            leasesDataEmpty = true;
        });

    </script>
    @endpush
</div>

