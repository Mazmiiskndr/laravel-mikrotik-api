@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_premium_service');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('premium-service.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Service Name</th>
                <th>Upload Rate</th>
                <th>Download Rate</th>
                <th>Duration</th>
                @if($canEdit)
                <th>Action</th>
                @endif
            </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script>
    var canEdit = @json($canEdit);
</script>
@endpush
