<div>
    <div wire:ignore.self class="modal fade" id="updateMacModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Mac</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="updateMac" method="POST">
                    <div class="modal-body">
                        {{-- FORM INPUT MAC ADDRESS AND STATUS --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="macAddressUpdate" label="Mac Address" model="macAddress"
                                    placeholder="Enter a Mac Address.." required />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-select-field id="status" label="Status" model="status" required :options="[
                                                                'bypassed' => 'Bypassed',
                                                                'blocked' => 'Blocked'
                                                                ]" tooltip="Bypassed device can get internet access without log in to hotspot and will get unlimited bandwidth. Blocked device
                                                                cannot get internet access even if the device already logged in to hotspot." />
                            </div>
                        </div>

                        {{-- FORM INPUT SERVER AND DESCRIPTION --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-select-field id="serverUpdate" label="Server" model="server" required :options="$servers"
                                    tooltip="Choose on which hotspot server this mac address will be bypassed/blocked." />

                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="descriptionUpdate" label="Description" model="description"
                                    placeholder="Enter a Description.."
                                    tooltip="Note for bypass/blocked device, for example why the device is bypassed/blocked." />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <x-button color="secondary" dismiss="true" click="closeModal">
                            Close
                        </x-button>

                        <x-button type="submit" color="primary">
                            Save Changes
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
