<div>
    <div wire:ignore.self class="modal fade" id="updateAdminModal" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="updateAdmin" method="POST">
                    <div class="modal-body">

                        {{-- FORM INPUT ADMIN UID, CHOOSE GROUP AND USERNAME --}}
                        <div class="row">
                            <div class="col">
                                <x-input-field type="hidden" id="adminUid" model="admin_uid" required />
                                <x-select-field id="groupIdUpdate" label="Group" model="group_id" required
                                    :options="$groups->pluck('name', 'id')->toArray()" />
                            </div>
                            <div class="col">
                                <x-input-field id="usernameUpdate" label="Username" model="username" placeholder="Enter a Username.." required />
                            </div>
                        </div>

                        {{-- FORM INPUT PASSWORD, CONFIRM PASSWORD AND STATUS --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="passwordUpdate" class="form-label">Password </label>
                                <input type="password" id="passwordUpdate"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter a Password.." wire:model="password">
                                @if($password)
                                @error('password') <small class="error text-danger">{{ $message }}</small> @enderror
                                @else
                                <small class="text-danger">Leave it blank if you don't want it to change.</small>
                                @endif
                            </div>
                            <div class="col">
                                <x-select-field id="statusUpdate" label="Status" model="status" required :options="['1' => 'Active', '0' => 'Not Active']" />
                            </div>
                        </div>

                        {{-- TITLE ADMINISTRATOR DETAIL --}}
                        <div class="row mt-3">
                            <hr>
                            <h5>Administrator Details</h5>
                        </div>

                        {{-- FORM INPUT FULL NAME AND EMAIL ADDRESS --}}
                        <div class="row">
                            <div class="col">
                                <x-input-field id="fullNameUpdate" label="Full Name" model="fullname" placeholder="Enter a Full Name.." required />
                            </div>
                            <div class="col">
                                <x-input-field type="email" id="emailAddressUpdate" label="Email Address" model="email" placeholder="Enter a Email Address.." required />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
