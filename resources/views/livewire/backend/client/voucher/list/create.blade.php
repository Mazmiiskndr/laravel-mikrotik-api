<div>
    <div wire:ignore.self class="modal fade" id="createNewVoucherBatch" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add New Voucher Batch</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="storeNewVoucherBatch" method="POST">
                    <div class="modal-body">

                        {{-- FORM INPUT CHOOSE SERVICE, CHARACTERS LENGTH AND QUANTITY --}}
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <x-select-field id="idService" label="Service" model="idService" required
                                    :options="$services->pluck('service_name', 'id')->toArray()" />
                            </div>
                            <div class="col-lg-4 col-12">
                                <x-select-field id="charactersLength" label="Characters Length" model="charactersLength"
                                    required :options="[
                                        '6' => '6',
                                        '7' => '7',
                                        '8' => '8',
                                        '9' => '9',
                                        '10' => '10',
                                        '11' => '11',
                                        '12' => '12'
                                        ]" tooltip="Voucher code's length, for example 'adnlms' length is 6." />
                            </div>
                            <div class="col-lg-4 col-12">
                                <x-input-field type="number" id="quantity" label="Quantity" model="quantity"
                                    placeholder="Enter a Quantity.." required
                                    tooltip="Number of vouchers code you want to make."/>
                            </div>
                        </div>

                        {{-- FORM INPUT NOTES --}}
                        <div class="row mt-3">
                            <div class="col-lg-12 col-12">
                                <x-input-field type="text" id="notes" label="Notes" model="notes"
                                    placeholder="Enter a Notes.."
                                    tooltip="Internal note for this voucher batch, won't be shown to voucher's user." />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <x-button color="secondary" dismiss="true" click="closeModal">
                            Close
                        </x-button>

                        <x-button type="submit" color="primary">
                            Save
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
