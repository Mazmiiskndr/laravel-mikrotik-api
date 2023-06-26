<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('service.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Service Name</th>
                <th>Service Cost</th>
                <th>Idle Timeout</th>
                <th>Upload Rate</th>
                <th>Download Rate</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
