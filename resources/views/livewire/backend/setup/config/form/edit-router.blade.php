<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">
            Config - Edit Router
        </h5>
        <x-button color="close" dismiss="true" click="closeModal" />
    </div>
    <form wire:submit.prevent="updateRouter" method="POST">
        <div class="modal-body">
            {{-- Form Input Server IP Address, Mikrotik IP Address and API Port --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4 col-md-4 col-12">
                    <x-input-field id="serverIpAddress" label="Server IP Address" model="server_ip_address"
                        placeholder="Enter a Server IP Address.." required />
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <x-input-field id="mikrotikIpAddress" label="Mikrotik IP Address" model="mikrotik_ip_address"
                        placeholder="Enter a Mikrotik IP Address.." required />
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <x-input-field id="apiPort" label="API Port" model="mikrotik_api_port"
                        placeholder="Enter a API Port.." required />
                </div>
            </div>

            {{-- Form Input Temporary Username and Temporary Password --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-6 col-md-6 col-12">
                    <x-input-field id="temporaryUsername" label="Temporary Username" model="temporary_username"
                        placeholder="Enter a Temporary Username.." required />
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <x-input-field type="password" id="temporaryPassword" label="Temporary Password" model="temporary_password"
                        placeholder="Enter a Temporary Password.." />
                </div>
            </div>

            {{-- Form Input Radius Ports and Radius Secret --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-6 col-md-6 col-12">
                    <x-input-field id="radiusPorts" label="Radius Port" model="ports"
                        placeholder="Enter a Radius Port.." required />
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <x-input-field id="radiusSecret" label="Radius Secret" model="secret"
                        placeholder="Enter a Radius Secret.." required />
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
    {{-- @push('scripts')
    <script>
        window.addEventListener('showToast', function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.success('Success!');
        });
    </script>
    @endpush --}}
</div>
