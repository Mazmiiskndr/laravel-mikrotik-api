<div>
    <div wire:ignore.self class="modal fade" id="updateHotelRoomModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Hotel Room</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="updateHotelRoom" method="POST">
                    <div class="modal-body">

                        {{-- FORM INPUT SERVICES, ROOM NUMBER AND PASSWORD --}}
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-12 mb-3">
                                <x-select-field id="idServiceUpdate" label="Service" model="idService" required
                                    :options="$services->pluck('service_name', 'id')->toArray()" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                <x-input-field type="text" id="roomNumberUpdate" label="Room Number" model="roomNumber"
                                    placeholder="Enter a Room Number.." required readonly />
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                <x-input-field type="text" id="passwordUpdate" label="Password"
                                    model="password" placeholder="Enter a Password.."/>
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
