@extends('layouts/layoutMaster')
@section('title', 'List Services')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To List Services --}}
@if($permissions['isAllowedToListServices'])
<h4 class="fw-bold py-3 mb-1">List Services</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Services</h4>

            <div>
                {{-- /Start Button for Create New Service --}}
                @if ($permissions['isAllowedToAddNewService'])
                <a href="{{ route('backend.services.add-new-service') }}" class="btn btn-facebook text-white">
                    <i class="tf-icons fas fa-plus-circle ti-xs me-1"></i>&nbsp; Add New Service
                </a>
                @endif
                {{-- /End Button for Create New Service --}}

            </div>

        </div>
    </div>

    @if($permissions['isAllowedToListServices'])
    {{-- Start List DataTable --}}
    <div class="card-body">
        @livewire('backend.service.list.data-table')
    </div>
    {{-- End List DataTable --}}
    @endif

</div>
@push('scripts')
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/backend/service/service-management.js') }}"></script>
@if (session()->has('success'))
<div id="successToastService" class="bs-toast toast toast-ex animate__animated my-2 fade animate__fadeInUp bg-white"
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
    var $toast = $('#successToastService');
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
