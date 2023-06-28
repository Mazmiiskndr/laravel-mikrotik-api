@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_ad');
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_ad');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable" data-route="{{ route('ads.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Device Type</th>
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
