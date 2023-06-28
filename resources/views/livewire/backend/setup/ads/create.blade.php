<div>
    <div wire:ignore.self class="modal fade" id="createNewAd" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add New Ad</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="storeNewAd" method="POST">
                    <div class="modal-body">
                        {{-- ALERT MESSAGES --}}
                        <div class="row">
                            <div class="col">
                                @if ($alert)
                                <div class="alert alert-{{ $alert['type'] }}" role="alert">
                                    {!! $alert['message'] !!}
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- FORM SELECT TYPE AND DEVICE TYPE --}}
                        <div class="row">
                            <div class="col">
                                <x-select-field id="type" label="Type" model="type" required
                                    :options="$adsType->pluck('title', 'name')->toArray()" />
                            </div>
                            <div class="col">
                                <x-select-field id="deviceType" label="Device Type" model="deviceType" required
                                    :options="['Desktop' => 'Desktop', 'Mobile' => 'Mobile']" />
                            </div>
                        </div>

                        {{-- FORM INPUT FILE AND TITLE --}}
                        <div class="row mt-3">
                            <div class="col">
                                <x-input-field type="file" id="imageBanner" label="Image Banner" model="imageBanner"
                                    required />
                            </div>
                            <div class="col">
                                <x-input-field type="text" id="title" label="Title" model="title"
                                    placeholder="Enter a Title.." required />
                            </div>
                        </div>

                        {{-- FORM INPUT URL FOR IMAGE AND POSITION --}}
                        <div class="row mt-3">
                            <div class="col">
                                <x-input-field type="text" id="urlForImage" label="URL For Image"
                                    placeholder="Enter a URL For Image.." model="urlForImage" />
                            </div>
                            <div class="col">
                                <x-input-field type="text" id="position" label="Position" model="position"
                                    placeholder="Enter a Position.." />
                            </div>
                        </div>

                        {{-- FORM INPUT URL FOR IMAGE AND POSITION --}}
                        <div class="row mt-3">
                            <div class="col">
                                <x-input-field type="text" id="timeToShow" label="From" placeholder="From - (YYYY-MM-DD)."
                                    model="timeToShow" />
                            </div>
                            <div class="col">
                                <x-input-field type="text" id="timeToHide" label="To" model="timeToHide"
                                    placeholder="To - (YYYY-MM-DD)" />
                            </div>
                        </div>

                        {{-- FORM INPUT URL FOR IMAGE AND POSITION --}}
                        <div class="row mt-3">
                            <div class="col">
                                <x-textarea type="text" id="shortDescription" label="Short Description"
                                    model="shortDescription" placeholder="Enter a Short Description.." />
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
