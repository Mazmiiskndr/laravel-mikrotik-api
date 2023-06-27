<div>
    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false" wire:ignore.self>
        {{-- Router Form Edit --}}
        @if($livewireComponentName == 'form.hotel_rooms')
        <div class="modal-dialog modal-dialog-centered" role="document">
            @elseif($livewireComponentName == 'form.users_data' || $livewireComponentName == 'form.social_plugins')
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                @else
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    @endif

                    <!-- Livewire component will be rendered here -->
                    <div class="modal-content">

                        {{-- Router Form Edit --}}
                        @if($livewireComponentName == 'form.edit-router')
                        @livewire('backend.setup.config.form.edit-router')

                        {{-- Clients Form Edit --}}
                        @elseif($livewireComponentName == 'form.clients')
                        @livewire('backend.setup.config.form.clients')

                        {{-- Hotel Rooms Form Edit --}}
                        @elseif($livewireComponentName == 'form.hotel_rooms')
                        @livewire('backend.setup.config.form.hotel-rooms')

                        {{-- Users Data Form Edit --}}
                        @elseif($livewireComponentName == 'form.users_data')
                        @livewire('backend.setup.config.form.users-data')

                        {{-- Social Plugins Data Form Edit --}}
                        @elseif($livewireComponentName == 'form.social_plugins')
                        @livewire('backend.setup.config.form.social-plugins')

                        {{-- Ads Data Form Edit --}}
                        @elseif($livewireComponentName == 'form.ads')
                        @livewire('backend.setup.config.form.ads')

                        {{-- Log Activities Data Form Edit --}}
                        @elseif($livewireComponentName == 'form.log-activity')
                        @livewire('backend.setup.config.form.log-activity')
                        @endif

                    </div>
                </div>
                @push('scripts')
                <script>
                    // Listen for the showModalByName event
                window.addEventListener('show-modal', () => {
                    $('#modalCenter').modal('show');
                });
                window.addEventListener('hide-modal', () => {
                    $('#modalCenter').modal('hide');
                });
                </script>

                @endpush
            </div>
        </div>
