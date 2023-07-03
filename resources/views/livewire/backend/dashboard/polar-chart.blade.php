<div class="col-lg-6 col-12 mb-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">User Active</h5>
        </div>
        <div class="card-body">
            @if ($chartData)
            <div wire:loading.remove id="userActiveChart" data-chart='@json($chartData)'></div>
            <div wire:loading>Loading...</div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
{{-- Apex Chart --}}
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
    // Define the polling interval
    let pollingInterval;

    // When load page finished
    Livewire.onLoad(() => {
        // Get data from api
        Livewire.emit('getLoadData');
    });

    // Stop polling when the 'stopGetData' event is emitted
    window.addEventListener('stopGetData', function (e) {
        clearInterval(pollingInterval);
    });
</script>
<script src="{{ asset('assets/js/backend/dashboard/polar-chart.js') }}"></script>
@endpush
