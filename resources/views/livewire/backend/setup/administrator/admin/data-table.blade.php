@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_admin');
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_admin');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('admin.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Group</th>
                <th>Email</th>
                <th>Status</th>
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
