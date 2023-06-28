@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_service');
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_service');
@endphp
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
</script>
@endpush
