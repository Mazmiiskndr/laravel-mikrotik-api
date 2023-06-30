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
                {{-- TODO: BUTTON DISCONNECT AND BUTTON BLOCK MAC ADDRESS --}}
                {{-- /Start Button for Export To CSV --}}
                @livewire('backend.report.list-online-user.save-to-excel')
                {{-- /End Button for Export To CSV --}}

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
{{-- TODO: --}}
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/backend/service/service-management.js') }}"></script> --}}
@endpush

@endif

@endsection
