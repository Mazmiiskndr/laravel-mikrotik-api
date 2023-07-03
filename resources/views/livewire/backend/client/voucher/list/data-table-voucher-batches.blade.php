@php
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_client');
$canBatchDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('batch_delete_clients');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('voucherBatches.getDataTable') }}">
        <thead>
            <tr>
                @if($canBatchDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Service Name</th>
                <th>Quantity</th>
                <th>Note</th>
                <th>Created By</th>
                <th>Created Date</th>
                @if($canDelete)
                <th>Action</th>
                @endif

            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    var canDelete = @json($canDelete);
    var canBatchDelete = @json($canBatchDelete);
</script>
@endpush
