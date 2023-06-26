@php
$canEdit = App\Helpers\AccessControlHelper::isAllowedToPerformAction('edit_group');
@endphp
<div wire:ignore class="table" >
    <table class="table table-hover table-responsive display" id="myTable" data-route="{{ route('group.getDataTable') }}" >
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
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
