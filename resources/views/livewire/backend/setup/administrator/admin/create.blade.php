<div>
    <div wire:ignore.self class="modal fade" id="createNewAdmin" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add New Admin</h5>
                    <x-button color="close" dismiss="true" click="closeModal" />
                </div>
                <form wire:submit.prevent="storeNewAdmin" method="POST">
                    <div class="modal-body">

                        {{-- FORM INPUT CHOOSE GROUP AND USERNAME --}}
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <x-select-field id="groupId" label="Group" model="groupId" required
                                    :options="$groups->pluck('name', 'id')->toArray()" />
                            </div>
                            <div class="col-lg-6 col-12">
                                <x-input-field id="username" label="Username" model="username"
                                    placeholder="Enter a Username.." required />
                            </div>
                        </div>

                        {{-- FORM INPUT PASSWORD, CONFIRM PASSWORD AND STATUS --}}
                        <div class="row mt-3">
                            <div class="col-lg-4 col-6">
                                <x-input-field type="password" id="password" label="Password" model="password"
                                    placeholder="Enter a Password.." required />
                            </div>
                            <div class="col-lg-4 col-6">
                                <x-input-field type="password" id="confirmPassword" label="Confirm Password"
                                    model="password_confirmation" placeholder="Enter a Confirm Password.." required />
                            </div>
                            <div class="col-lg-4 col-12">
                                <x-select-field id="status" label="Status" model="status" required
                                    :options="['1' => 'Active', '0' => 'Not Active']"
                                    tooltip="Not active administrator cannot log in to Megalos." />
                            </div>
                        </div>

                        {{-- TITLE ADMINISTRATOR DETAIL --}}
                        <div class="row mt-3">
                            <hr>
                            <h5>Administrator Details</h5>
                        </div>

                        {{-- FORM INPUT FULL NAME AND EMAIL ADDRESS --}}
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <x-input-field id="fullName" label="Full Name" model="fullName"
                                    placeholder="Enter a Full Name.." required />
                            </div>
                            <div class="col-lg-6 col-12">
                                <x-input-field type="email" id="emailAddress" label="Email Address" model="emailAddress"
                                    placeholder="Enter a Email Address.." required />
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
