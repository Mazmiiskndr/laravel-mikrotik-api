{{-- This is the card body section --}}
<div class="card-body">
    {{-- This is a form which uses a livewire event to prevent the default form submission --}}
    <form wire:submit.prevent="updateService" method="POST">
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
                <x-input-group type="number" type="number" id="downloadRateUpdate" label="Download Rate" model="downloadRate"
                    placeholder="Download Rate" appendText="Kbps" required
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

        {{-- TITLE Burst Settings --}}
        <div class="row">
            <hr>
            <h5>Burst Settings <small>(If you want to enable burst and priority you must fill all the field
                    below)</small></h5>
        </div>

        {{-- FORM INPUT DOWNLOAD BURST RATE AND UPLOAD BURST RATE --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" id="downloadBurstRateUpdate" label="Download Burst Rate"
                    model="downloadBurstRate" placeholder="Download Burst Rate" appendText="Kbps" required
                    tooltip="Temporary additional download rate applies if average rate in last burst-time seconds is below burst-threshold; stops when it equals or exceeds the threshold." />
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-group type="number" id="uploadBurstRateUpdate" label="Upload Burst Rate" model="uploadBurstRate"
                    placeholder="Upload Burst Rate" appendText="Kbps" required
                    tooltip="Temporary additional upload rate applies similarly, triggered below and stopping at the burst-threshold." />
            </div>
        </div>

        {{-- FORM INPUT DOWNLOAD BURST TIME AND UPLOAD BURST TIME --}}
        <div class="row">
            <div class="col-lg-5 col-md-4 col-12 mb-3">
                <x-input-group type="number" id="downloadBurstTimeUpdate" label="Download Burst Time"
                    model="downloadBurstTime" placeholder="Download Burst Time" appendText="Seconds" required
                    tooltip="See download burst rate explanation." />
            </div>
            <div class="col-lg-4 col-md-4 col-6 mb-3">
                <x-input-group type="number" id="uploadBurstTimeUpdate" label="Upload Burst Time" model="uploadBurstTime"
                    placeholder="Upload Burst Time" appendText="Seconds" required
                    tooltip="See upload burst rate explanation." />
            </div>
            <div class="col-lg-3 col-md-4 col-6 mb-3">
                <x-input-field type="number" id="priorityUpdate" label="Priority" model="priority"
                    placeholder="Enter a Priority.."
                    tooltip="Bandwidth priority for a user. 1 is the higher priority and 8 is the lowest priority." />
            </div>
        </div>

        {{-- TITLE Time Limit Settings --}}
        <div class="row">
            <hr>
            <h5>Time Limit Settings</h5>
        </div>

        {{-- FORM INPUT LIMIT TPYE, TIME LIMIT AND UNIT TIME --}}
        <div class="row">
            <div class="col-lg-5 col-md-5 col-12 mb-3">
                <x-select-field id="limitTypeUpdate" model="limitType" label="Limit Type" :options="[
                        'one_time_continuous' => 'One-Time Continuously',
                        'one_time_gradually' => 'One-Time Gradually'
                        ]"
                    tooltip="Continual time limit counts after login, irrespective of online status. Gradual time limit only counts during active logins." />
            </div>
            <div class="col-lg-4 col-md-4 col-6 mb-3">
                <x-input-field type="number" id="timeLimitUpdate" label="Time Limit" model="timeLimit"
                    placeholder="Enter a Time Limit.." required
                    tooltip="Limit usage by time, after this limit is reached the user become invalid." />
            </div>
            <div class="col-lg-3 col-md-3 col-6 mb-3">
                <x-select-field id="unitTimeUpdate" model="unitTime" label="Unit Time" :options="[
                        'minutes' => 'Minutes',
                        'hours' => 'Hours',
                        'days' => 'Days',
                        ]" placeholder="false" />
            </div>
        </div>

        {{-- TITLE Validity Settings --}}
        <div class="row">
            <hr>
            <h5>Validity Settings</h5>
        </div>

        {{-- FORM INPUT VALID FROM AND VALIDITY TYPE --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-input-field type="text" id="validFromUpdate" label="Valid From" model="validFrom"
                    placeholder="(YYYY-MM-DD HH:MM:SS)" required
                    tooltip="User can be used after this specified time." />
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <x-select-field id="validityTypeUpdate" model="validityType" label="Validity Type" :options="[
                                'none' => '-- Choose Validity Type --',
                                'after_created' => 'Calculated After Created',
                                'after_first_login' => 'Calculated After First Login'
                                ]" tooltip="After first login validity is counted after the first login to the hotspot. After created validity is counted after user
                    created." placeholder="false" />
            </div>
        </div>

        {{-- FORM INPUT VALIDITY AND UNIT VALIDITY --}}
        <div class="row">
            <div class="col-lg-8 col-md-8 col-6 mb-3">
                <x-input-field type="text" id="validityUpdate" label="Validity" model="validity"
                    placeholder="Enter a Validity.." required
                    tooltip="How long a user can be used before become invalid." />
            </div>

            <div class="col-lg-4 col-md-4 col-6 mb-3">
                <x-select-field id="unitValidityUpdate" model="unitValidity" label="Unit Validity" :options="[
                    'days' => 'Days',
                    'months' => 'Months',
                    'years' => 'Years',
                    ]" placeholder="false" />
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
                <x-select-field id="unitTimeDurationUpdate" model="unitTimeDuration" label="Unit Time Duration" :options="[
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
