@extends('layouts/layoutMaster')
@section('title', 'Users Data')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To Users Data --}}
@if($permissions['isAllowedToUsersData'])
<h4 class="fw-bold py-3 mb-1">Users Data</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Users Data</h4>
        </div>
    </div>

    @if($permissions['isAllowedToUsersData'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        {{-- TODO: --}}
        {{-- @livewire('backend.client.users-data.data-table') --}}
    </div>
    {{-- End List DataTable --}}
    @endif

    @push('scripts')
    <script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/backend/client/voucher/list-active-vouchers-management.js') }}"></script>
    @endpush
</div>
@endif

@endsection
