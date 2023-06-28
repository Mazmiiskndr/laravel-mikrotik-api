<div>
    <div wire:ignore.self class="modal fade" id="updateClientModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Client</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="updateClient" method="POST">
                    <div class="modal-body">
                        {{-- FORM INPUT CHOOSE SERVICE AND USERNAME --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-select-field id="idServiceUpdate" label="Service" model="idService" required
                                    :options="$services->pluck('service_name', 'id')->toArray()" />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="usernameUpdate" label="Username" model="username" placeholder="Enter a Username.."
                                    required readonly
                                    tooltip="Username length is between 5 and 32. Username may only contain lower case alphabet and numeric characters, '@' sign, dots and underscores." />
                            </div>
                        </div>

                        {{-- FORM INPUT PASSWORD AND SIMULTANEOUS USE --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="passwordUpdate" label="Password" model="password" placeholder="Enter a Password.."
                                    required
                                    tooltip="Password length is between 5 and 32." />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="number" id="simultaneousUseUpdate" label="Simultaneous Use" model="simultaneousUse"
                                    placeholder="Enter a Simultaneous Use.."
                                    tooltip="The maximum number of simultaneous online (logged in to hotspot) devices for one user. Simultaneous use in Service will be ignored." />
                            </div>
                        </div>

                        {{-- FORM INPUT PASSWORD, CONFIRM PASSWORD AND STATUS --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="validFromUpdate" label="Valid From" model="validFrom"
                                    placeholder="(YYYY-MM-DD HH:MM:SS)" tooltip="User can be used after this specified time." />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="validToUpdate" label="Valid To" model="validTo" placeholder="(YYYY-MM-DD HH:MM:SS)"
                                    tooltip="User can not be used after this specified time." />
                            </div>
                        </div>

                        {{-- TITLE Client Details --}}
                        <div class="row">
                            <hr>
                            <h5>Client Details (Optional)</h5>
                        </div>

                        {{-- FORM INPUT IDENTIFICATION NO. AND EMAIL ADDRESS --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="identificationNoUpdate" label="Identification No."
                                    model="identificationNo" placeholder="Enter a Identification Number.." />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="email" id="emailAddressUpdate" label="Email Address"
                                    model="emailAddress" placeholder="Enter a Email Address.." />
                            </div>
                        </div>

                        {{-- FORM INPUT FIRST NAME AND LAST NAME --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="firstNameUpdate" label="First Name" model="firstName"
                                    placeholder="Enter a First Name.." />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="lastNameUpdate" label="Last Name" model="lastName"
                                    placeholder="Enter a Last Name.." />
                            </div>
                        </div>

                        {{-- FORM INPUT PLACE OF BIRTH AND DATE OF BIRTH --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="placeOfBirthUpdate" label="Place of birth"
                                    model="placeOfBirth" placeholder="Enter a Place of birth.." />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="dateOfBirthUpdate" label="Date of birth"
                                    model="dateOfBirth" placeholder="Date of birth - (YYYY-MM-DD)" />
                            </div>
                        </div>

                        {{-- FORM INPUT PLACE OF BIRTH AND DATE OF BIRTH --}}
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="phoneUpdate" label="Phone" model="phone"
                                    placeholder="Phone" />
                            </div>
                            <div class="col-lg-6 col-12 mb-3">
                                <x-input-field type="text" id="addressUpdate" label="Address" model="address"
                                    placeholder="Enter a Address.." />
                            </div>
                        </div>

                        {{-- FORM NOTES --}}
                        <div class="row">
                            <div class="col">
                                <x-input-field type="text" id="notesUpdate" label="Notes" model="notes"
                                    placeholder="Enter a Notes.." />
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
