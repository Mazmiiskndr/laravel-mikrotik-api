<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">
            Config - Edit Users Data
        </h5>
        <x-button color="close" dismiss="true" click="closeModal" />
    </div>
    <form wire:submit.prevent="updateUserData" method="POST">
        <div class="modal-body">
            {{-- Form Input ID Column, Name Column and Email Column --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-select-field id="idColumn" label="Id Column" model="id_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="nameColumn" label="Name Column" model="name_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="emailColumn" label="Email Column" model="email_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
            </div>

            {{-- Form Input Phone Number Column, Room Number Column and Date Column --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-select-field id="phoneNumberColumn" label="Phone Number Column" model="phone_number_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="roomNumberColumn" label="Room Number Column" model="room_number_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="dateColumn" label="Date Column" model="date_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
            </div>

            {{-- Form Input First Name Column, Last Name Column and Mac Column --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-select-field id="firstNameColumn" label="First Name Column" model="first_name_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="lastNameColumn" label="Last Name Column" model="last_name_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="macColumn" label="Mac Column" model="mac_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
            </div>

            {{-- Form Input Location Column, Gender Column and Birthday Column --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-select-field id="locationColumn" label="Location Column" model="location_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="genderColumn" label="Gender Column" model="gender_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-select-field id="birthdayColumn" label="Birthday Column" model="birthday_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
            </div>

            {{-- Form Input Login With Column, Display ID and Display Name --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-select-field id="loginWithColumn" label="Login With Column" model="login_with_column" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayId" label="Display ID" model="display_id"
                        placeholder="Enter a Display ID.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayName" label="Display Name" model="display_name"
                        placeholder="Enter a Display Name.." required />
                </div>
            </div>

            {{-- Form Input Display Email, Display Phone Number and Display Room Number --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-input-field id="displayEmail" label="Display Email" model="display_email"
                        placeholder="Enter a Display Email.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayPhoneNumber" label="Display Phone Number" model="display_phone_number"
                        placeholder="Enter a Display Phone Number.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayRoomNumber" label="Display Room Number" model="display_room_number"
                        placeholder="Enter a Display Room Number.." required />
                </div>
            </div>

            {{-- Form Input Display Date, Display First Name and Display Last Name --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-input-field id="displayDate" label="Display Date" model="display_date"
                        placeholder="Enter a Display Date.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayFirstName" label="Display First Name" model="display_first_name"
                        placeholder="Enter a Display First Name.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayLastName" label="Display Last Name" model="display_last_name"
                        placeholder="Enter a Display Last Name.." required />
                </div>
            </div>

            {{-- Form Input Display Mac, Display Location and Display Gender --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-12 mb-0">
                    <x-input-field id="displayMac" label="Display Mac" model="display_mac"
                        placeholder="Enter a Display Mac.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayLocation" label="Display Location" model="display_location"
                        placeholder="Enter a Display Location.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayGender" label="Display Gender" model="display_gender"
                        placeholder="Enter a Display Gender.." required />
                </div>
            </div>

            {{-- Form Input Display Birthday and Display Login With --}}
            <div class="row g-2">
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayBirthday" label="Display Birthday" model="display_birthday"
                        placeholder="Enter a Display Birthday.." required />
                </div>
                <div class="col-lg-4 col-6 mb-0">
                    <x-input-field id="displayLoginWith" label="Display Login With" model="display_login_with"
                        placeholder="Enter a Display Login With.." required />
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
