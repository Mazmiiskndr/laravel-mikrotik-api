<div class="row">
    <form wire:submit.prevent="storeService" method="POST">
        <div class="row">

            <div class="col-12 mb-3">
                <x-select-field id="idService" label="Service" model="idService" required
                    :options="$services->pluck('service_name', 'id')->toArray()" />
            </div>

            <div class="col-12">
                <x-input-field id="cronType" label="Cron Type" model="cronType" placeholder="Enter a Cron Type.." required />
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <x-button type="submit" color="primary">
                    Save
                </x-button>
            </div>

        </div>


    </form>
</div>
