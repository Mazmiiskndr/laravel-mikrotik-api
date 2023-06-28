<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ (!empty($containerNav) ? $containerNav : 'container-fluid') }}">
        <div class="footer-container d-flex align-items-center justify-content-center py-2 flex-md-row flex-column">
            <div>
                © {{ date('Y') }}
                , Created by ❤️ <a
                    href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '') }}"
                    target="_blank" class="fw-semibold">{{ (!empty(config('variables.creatorName')) ?
                    config('variables.creatorName') : '') }}</a>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
<style>
    .toast.showing {
        top: 77px;
        right: 25px;
        opacity: 0;
    }
</style>
@endpush
@push('scripts')
<div id="successToast" class="bs-toast toast toast-ex animate__animated my-2 fade animate__fadeInUp bg-white"
    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header bg-white">
        <i class="ti ti-check ti-sm me-2 text-success"></i>
        <div class="me-auto fw-semibold" style="color: #1d1d1d">Success</div>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div id="toastBody" class="toast-body" style="color: #1d1d1d"></div>
</div>
<script>
    // Listen for 'message' event from the window
    window.addEventListener('message', event => {
        // Check if the event contains an error detail
        if (event.detail && event.detail.error) {
            const error = event.detail.error;
            // Display an error message using Swal.fire
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error,
            });
        }
        // Check if the event contains a success detail
        if (event.detail && event.detail.success) {
            const success = event.detail.success;
            // Display a success toast notification
            var $toast = $('#successToast');
            $('#toastBody').text(success);
            $toast.addClass('show showing');
            setTimeout(function() {
                $toast.removeClass('show showing');
            }, 3000);
        }
    });
</script>
@endpush

{{-- @push('scripts')
<script>
    // Listen for 'message' event from the window
        window.addEventListener('message', event => {
            // Check if the event contains an error detail
            if (event.detail && event.detail.error) {
            const error = event.detail.error;
            // Display an error message using Swal.fire
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error,
            });
        }
        // Check if the event contains a success detail
        if (event.detail && event.detail.success) {
                const success = event.detail.success;
                // Display an success message using Swal.fire
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: success,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
</script>
@endpush --}}
