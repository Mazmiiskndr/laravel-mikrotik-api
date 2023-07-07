@php
$canDelete = App\Helpers\AccessControlHelper::isAllowedToPerformAction('delete_users_data');
$printCsv = App\Helpers\AccessControlHelper::isAllowedToPerformAction('users_data_csv');
@endphp
<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('usersData.getDataTable') }}">
        <thead>
            <tr>
                @if($canDelete)
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox'
                        id='select-all-checkbox'>
                </th>
                @endif
                <th>No</th>
                <th>Guest Name</th>
                <th>Email Address</th>
                <th>Room Number</th>
                <th>Input Date</th>
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
    var printCsv = @json($printCsv);
</script>
@endpush
