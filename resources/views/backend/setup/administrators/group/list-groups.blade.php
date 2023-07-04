@extends('layouts/layoutMaster')
@section('title', 'List Groups')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush

@section('content')

{{-- Is Allowed User To List Groups --}}
@if($permissions['isAllowedToListGroups'])
<h4 class="fw-bold py-3 mb-1"><span class="text-primary fw-light">Groups </span>/ List</h4>
<div class="row">
    <!-- DataTable with Buttons -->
    <div class="col-md-12">
        <div class="card">
            {{-- Card Header --}}
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Table Groups</h4>
                    @if ($permissions['isAllowedToAddNewGroup'])
                    <a href="{{ route('backend.setup.admin.add-new-group') }}"
                        class="btn btn-sm btn-facebook text-white" data-turbolinks-action="replace">
                        <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Group
                    </a>
                    @endif
                </div>
            </div>

            {{-- Start List DataTable --}}
            <div class="card-body">
                @livewire('backend.setup.administrator.group.data-table')
            </div>
            {{-- End List DataTable --}}


        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/backend/setup/administrator/group/group-management.js') }}"></script>
@if (session()->has('success'))
<div id="successToastGroup" class="bs-toast toast toast-ex animate__animated my-2 fade animate__fadeInUp bg-white"
    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header bg-white">
        <i class="ti ti-check ti-sm me-2 text-success"></i>
        <div class="me-auto fw-semibold" style="color: #1d1d1d">Success</div>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div id="toastBody" class="toast-body" style="color: #1d1d1d"></div>
</div>
<script>
    // Display a success toast notification
    var $toast = $('#successToastGroup');
    $('#toastBody').text("{{ session('success') }}");

    $toast.addClass('show showing');

    setTimeout(function() {
    $toast.removeClass('show showing');
    }, 3000);
</script>
@endif
@endpush

@endif

@endsection
