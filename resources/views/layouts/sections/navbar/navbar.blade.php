@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme"
    id="layout-navbar">
    @endif
    @if(isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{$containerNav}}">
            @endif

            <!--  Brand demo (display only for navbar-full and hide on below xl) -->
            @if(isset($navbarFull))
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                <a href="{{url('/')}}" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        @include('_partials.macros',["height"=>20])
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
                </a>
            </div>
            @endif

            <!-- ! Not required for layout-without-menu -->
            @if(!isset($navbarHideToggle))
            <div
                class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="ti ti-menu-2 ti-sm"></i>
                </a>
            </div>
            @endif

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                <!-- Style Switcher -->
                <div class="navbar-nav align-items-center">
                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);"
                        aria-label="Style Switcher">
                        <i class='ti ti-sm'></i>
                    </a>
                </div>
                <!--/ Style Switcher -->

                <ul class="navbar-nav flex-row align-items-center ms-auto">

                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown" aria-label="Dropdown Toggle">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('assets/img/avatars/default.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @livewire('backend.profile.my-profile', ['user_uid' => session('user_uid')])
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="javascript:void(0)" onclick="showMyProfile('{{session('user_uid')}}')">
                                    <i class="ti ti-user-check me-2 ti-sm"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                                @if (session('login_status') == "Active")
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                    onclick="logoutButton();">
                                    <i class='ti ti-logout me-2'></i>
                                    <span class="align-middle">Logout</span>
                                </a>
                            </li>
                            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                @csrf
                            </form>
                            @endif
                        </ul>
                    </li>
                    <!--/ User -->
                </ul>
            </div>

            @if(!isset($navbarDetached))
        </div>
        @endif
    </nav>
    @livewire('backend.profile.edit-my-profile')
    @push('scripts')
    <script>
        // Hide Modal
        window.addEventListener('hide-my-profile-modal', () => {
            $('#updateMyProfileModal').modal('hide');
        });
        window.addEventListener('show-my-profile-modal', () => {
            $('#updateMyProfileModal').modal('show');
        });
        // Function to show a modal based on a given uid for UPDATE!
        function showMyProfile(uid) {
            // Emit an event to show the modal with the given Livewire component uid for UPDATE!
            Livewire.emit('getMyProfile', uid);
        }
        function logoutButton() {
            event.preventDefault();
            Swal.fire({
                title: 'You sure want to logout?',
                text: "You will no longer be able to access the data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout!',
            }).then((result) => {
                // If Result is True then submit the form will be logout
                if (result.isConfirmed) {
                    document.querySelector("#logout-form").submit();
                }
            });
        }
    </script>
    @endpush
    <!-- / Navbar -->
