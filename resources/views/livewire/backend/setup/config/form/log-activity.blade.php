<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">
            Config - Edit Log Activities
        </h5>
        <x-button color="close" dismiss="true" click="closeModal" />
    </div>
    <form wire:submit.prevent="updateActivity" method="POST">
        <div class="modal-body">

            {{-- Form Select Log Activities--}}
            <div class="row">
                <div class="col mb-3">
                    <x-select-field id="logActivity" label="Log Activities"
                        model="logActivity" required
                        :options="['1' => 'Active', '0' => 'Non Active']" />
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
