<div wire:ignore class="table" data-voucher-batch-id="{{ $voucherBatchId }}">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('detailVoucherBatch.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>S/N</th>
                <th>Username</th>
                <th>Password</th>
                <th>Total Time Used</th>
                <th>Valid Until</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>
