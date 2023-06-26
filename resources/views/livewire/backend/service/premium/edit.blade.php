{{-- This is the card body section --}}
<div class="card-body">
    {{-- This is a form which uses a livewire event to prevent the default form submission --}}
    <form wire:submit.prevent="updatePremiumService" method="POST">
        {{-- FORM INPUT SERVICE NAME AND DESCRIPTION --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-field type="text" id="serviceNameUpdate" label="Service Name" model="serviceName"
                    placeholder="Enter a Service Name.." required readonly />
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-field type="text" id="descriptionUpdate" label="Description" model="description"
                    placeholder="Enter a Description.." />
            </div>
        </div>

        {{-- FORM INPUT DOWNLOAD RATE AND UPLOAD RATE --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" type="number" id="downloadRateUpdate" label="Download Rate"
                    model="downloadRate" placeholder="Download Rate" appendText="Kbps" required
                    tooltip="Download speed on kilobit per second (Kbps)." />
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" id="uploadRateUpdate" label="Upload Rate" model="uploadRate"
                    placeholder="Upload Rate" appendText="Kbps" required
                    tooltip="Upload speed on kilobit per second (Kbps)." />
            </div>
        </div>

        {{-- FORM INPUT IDLE TIMEOUT AND SESSION TIMEOUT --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" id="idleTimeoutUpdate" label="Idle Timeout" model="idleTimeout"
                    placeholder="Idle Timeout" appendText="Seconds"
                    tooltip="The amount of time in seconds a user can be inactive before the user disconnected automatically from hotspot." />
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" id="sessionTimeoutUpdate" label="Session Timeout" model="sessionTimeout"
                    placeholder="Session Timeout" appendText="Seconds"
                    tooltip="How long a user can connect to the hotspot before being required to manually re-login." />
            </div>
        </div>

        {{-- FORM INPUT IDLE TIMEOUT AND SESSION TIMEOUT --}}
        <div class="row">
            <div class="col-lg-5 col-md-4 col-12 mb-3">
                <x-input-field type="number" id="serviceCostUpdate" label="Service Cost" model="serviceCost"
                    placeholder="Enter a Service Cost.." />
            </div>
            <div class="col-lg-4 col-md-4 col-6 mb-3">
                <x-select-field id="currencyUpdate" label="Currency" model="currency" :options="[
                        'IDR' => 'IDR',
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'SGD' => 'SGD',
                        'HKD' => 'HKD',
                        'AUD' => 'AUD',
                        'JPY' => 'JPY'
                        ]" placeholder="false" />
            </div>
            <div class="col-lg-3 col-md-4 col-6 mb-3">
                <x-input-field type="number" id="simultaneousUseUpdate" label="Simultaneous Use" model="simultaneousUse"
                    placeholder="Enter a Simultaneous Use.."
                    tooltip="The maximum number of simultaneous online (logged in to hotspot) devices for one user. Will be ignored if simultaneous use on clients section is set." />
            </div>
        </div>

        {{-- TITLE Use This Service For Online Purchase --}}
        <div class="row">
            <hr>
            <h5>Use This Service For Online Purchase</h5>
        </div>

        {{-- FORM INPUT LIMIT TPYE, TIME LIMIT AND UNIT TIME --}}
        <div class="row">
            <div class="col-lg-8 col-md-6 col-6 mb-3">
                <x-input-field type="number" id="timeDurationUpdate" label="Time Duration" model="timeDuration"
                    placeholder="Enter a Time Duration.." required />
            </div>
            <div class="col-lg-2 col-md-6 col-6 mb-3">
                <x-select-field id="unitTimeDurationUpdate" model="unitTimeDuration" label="Unit Time Duration"
                    :options="[
                        'hours' => 'Hours',
                        'days' => 'Days',
                        ]" placeholder="false" />

            </div>
            <div class="col-lg-2 col-md-6 col-6 mb-3">
                <x-select-field id="enableFeatureUpdate" model="enableFeature" label="Enable Feature" :options="[
                        '0' => 'No',
                        '1' => 'Yes'
                        ]" placeholder="false" />
            </div>
        </div>

        {{-- A row for the submit button --}}
        <div class="row mt-3">
            {{-- Column for the submit button --}}
            <div class="col-12">
                {{-- The submit button --}}
                <x-button type="submit" color="primary">
                    Save Changes
                </x-button>
            </div>
        </div>
    </form>
</div>
