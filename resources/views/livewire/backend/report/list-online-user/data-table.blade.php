<div wire:ignore class="table">
    <table class="table table-hover table-responsive display" id="myTable"
        data-route="{{ route('report.getDataTableListOnlineUsers') }}">
        <thead>
            <tr>
                <th id="th-1">
                    <input class="form-check-input" style="border: 1px solid #8f8f8f;" type='checkbox' id='select-all-checkbox'>
                </th>
                <th>No</th>
                <th>Username</th>
                <th>First Use</th>
                <th>Session Start</th>
                <th>Online Time</th>
                <th>IP Address</th>
                <th>MAC Address</th>
            </tr>
        </thead>
    </table>
</div>
