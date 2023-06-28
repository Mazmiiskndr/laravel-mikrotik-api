<div class="row">
    <form wire:submit.prevent="updateUrlRedirect" method="POST">
        <div class="row">

            <div class="col-12">
                <x-input-field id="url" label="URL After Login" model="url" placeholder="https://www.example.com/.."
                    required tooltip="User will be redirected to this URL after sucessful log in to hotspot." />
            </div>

            <div class="mt-3">
                <x-button type="submit" color="primary">
                    Save
                </x-button>
            </div>

        </div>

    </form>
</div>
