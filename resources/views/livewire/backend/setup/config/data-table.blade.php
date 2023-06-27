<div class="table">
    <table class="table table-hover table-responsive display" id="myTable" data-route="{{ route('config.getDataTable') }}">
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
    document.addEventListener("DOMContentLoaded", function() {
        Livewire.emit('loadLogActivitySwitch');
    });
</script>
@endpush
