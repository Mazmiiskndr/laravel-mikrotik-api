<div wire:ignore class="table" data-voucher-batch-id="{{ $voucherBatchId }}" data-voucher-batch-type="{{ $voucherBatch->type }}">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('detailVoucherBatch.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>S/N</th>
                <th>Username</th>
                @if($voucherBatch->type == 'with_password')
                <th>Password</th>
                @endif
                <th>Total Time Used</th>
                <th>Valid Until</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>
