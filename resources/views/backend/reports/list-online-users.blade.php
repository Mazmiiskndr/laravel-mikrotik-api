@extends('layouts/layoutMaster')
@section('title', 'List Online Users')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Online Users --}}
@if($permissions['isAllowedToListOnlineUsers'])
<h4 class="fw-bold py-3 mb-1">List Online Users</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Online Users</h4>

            <div>
                {{-- TODO: BUTTON DISCONNECT --}}
                {{-- /Start Button for Disconnect --}}
                <x-button type="button" color="youtube btn-sm" onclick="confirmAction('disconnect')">
                    <i class="tf-icons fas fa-power-off ti-xs me-1"></i>&nbsp; Disconnect
                </x-button>
                {{-- /End Button for Disconnect --}}

                {{-- /Start Button for Block Mac Addresses --}}
                <x-button type="button" color="warning btn-sm" onclick="confirmAction('block')">
                    <i class="tf-icons fas fa-ban ti-xs me-1"></i>&nbsp; Block Mac Addresses
                </x-button>
                {{-- /End Button for Block Mac Addresses --}}

                {{-- /Start Button for Export To Excel --}}
                @livewire('backend.report.list-online-user.save-to-excel')
                {{-- /End Button for Export To Excel --}}

            </div>

        </div>
    </div>

    @if($permissions['isAllowedToListOnlineUsers'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.report.list-online-user.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

</div>
@push('scripts')
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/backend/report/list-online-users-management.js') }}"></script>
@endpush

@endif

@endsection
