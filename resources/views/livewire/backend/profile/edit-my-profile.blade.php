<div>
    <div wire:ignore.self class="modal fade" id="updateMyProfileModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit My Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="updateMyProfile" method="POST">
                    <div class="modal-body">

                        {{-- FORM INPUT ADMIN UID, CHOOSE GROUP AND USERNAME --}}
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <x-input-field type="hidden" id="adminUidProfile" model="admin_uid" required />
                                <x-input-field id="groupNameProfile" label="Group Name" model="group_name" required readonly />
                            </div>
                            <div class="col-lg-6 col-12">
                                <x-input-field id="usernameUpdateProfile" label="Username" model="username" required readonly />
                            </div>
                        </div>

                        {{-- FORM INPUT PASSWORD, CONFIRM PASSWORD AND STATUS --}}
                        <div class="row mt-3">
                            <div class="col-lg-6 col-12">
                                <label for="passwordUpdateProfile" class="form-label">Password </label>
                                <input type="password" id="passwordUpdateProfile"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter a Password.." wire:model="password">
                                @if($password)
                                @error('password') <small class="error text-danger">{{ $message }}</small> @enderror
                                @else
                                <small class="text-danger">Leave it blank if you don't want it to change.</small>
                                @endif
                            </div>
                            <div class="col-lg-6 col-12">
                                <x-input-field id="statusProfile" label="Status" model="status_name" required readonly />
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
                                <x-input-field id="fullNameUpdateProfile" label="Full Name" model="fullname"
                                    placeholder="Enter a Full Name.." required />
                            </div>
                            <div class="col-lg-6 col-12">
                                <x-input-field type="email" id="emailAddressUpdateProfile" label="Email Address" model="email"
                                    placeholder="Enter a Email Address.." required />
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
