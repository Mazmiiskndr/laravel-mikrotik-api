@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_mac');
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_mac');
$canBatchDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('batch_delete_macs');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('blockedMacs.getDataTable') }}">
        <thead>
            <tr>
                @if($canBatchDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Mac Address</th>
                <th>Status</th>
                <th>Description</th>
                <th>Date</th>
                @if($canEdit || $canDelete)
                <th>Action</th>
                @endif

            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    var canEdit = @json($canEdit);
    var canDelete = @json($canDelete);
    var canBatchDelete = @json($canBatchDelete);
</script>
@endpush
