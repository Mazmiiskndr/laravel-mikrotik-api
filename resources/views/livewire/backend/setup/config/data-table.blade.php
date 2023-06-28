<div class="table" wire:ignore>
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('config.getDataTable') }}">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@push('scripts')
<script>
    function updateActivity(name, isChecked) {
        let html = isChecked ? 'On' : 'Off';
        $('#labelLogActivity').html(html);
        @this.call('updateActivity', isChecked);
    }
</script>
@endpush
