<form wire:submit.prevent="storeNewClient" method="POST">
    <div class="d-flex justify-content-between">
        {{-- FORM INPUT FROM DATE AND TO DATE --}}
        <div class="w-50 me-2">
            <x-input-field type="text" id="fromDate" label="From date" model="fromDate"
                placeholder="From Date - (YYYY-MM-DD)" />
        </div>
        <div class="w-50">
            <x-input-field type="text" id="toDate" label="To Date" model="toDate"
                placeholder="To Date - (YYYY-MM-DD)" />
        </div>
    </div>
</form>
