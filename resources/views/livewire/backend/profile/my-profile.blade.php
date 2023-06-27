<div>
    <a class="dropdown-item" onclick="showMyProfile('{{session('user_uid')}}')">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/default.png') }}" alt class="w-px-40 h-auto rounded-circle">
                </div>
            </div>
            <div class="flex-grow-1">
                @if(session('login_status') == "Active")
                <span class="fw-semibold d-block">
                    {{ $fullname }}
                </span>
                <small class="text-muted">
                    {{ $role }}
                </small>
                @endif
            </div>
        </div>
    </a>
</div>
