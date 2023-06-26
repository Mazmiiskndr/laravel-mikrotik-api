@extends('layouts/layoutMaster')
@section('title', 'Premium Services')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
{{-- Is Allowed User To Premium Services --}}
@if($permissions['isAllowedToPremiumServices'])
<h4 class="fw-bold py-3 mb-1">Premium Services</h4>
<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Table Premium Services</h4>
        </div>
    </div>

    @if($permissions['isAllowedToPremiumServices'])
    {{-- Start List Premium Services DataTable --}}
    <div class="card-body">
        @livewire('backend.service.premium.data-table')
    </div>
    {{-- End List Premium Services DataTable --}}
    @endif

</div>
@push('scripts')
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/datatable/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/backend/service/service-management.js') }}"></script> --}}
@if (session()->has('success'))
<div id="successToastPremiumService" class="bs-toast toast toast-ex animate__animated my-2 fade animate__fadeInUp bg-white"
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
        var $toast = $('#successToastPremiumService');
        $('#toastBody').text("{{ session('success') }}");

        $toast.addClass('show showing');

        setTimeout(function() {
            $toast.removeClass('show showing');
        }, 3000);

        // Function to show a modal for DELETE!
        function confirmDeleteService(id) {
            showSwalDialog('Are you sure?', 'You will not be able to restore this data!', () => {
                Livewire.emit('confirmService', id);
            });
        }

        // Helper function to show a Swal dialog
        function showSwalDialog(title, text, callback) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) {
                callback();
                }
            });
        }

</script>
@endif
@endpush

@endif

@endsection
