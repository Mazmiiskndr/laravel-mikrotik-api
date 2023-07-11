<div class="col-lg-12 col-md-12 mb-4">
    <div class="card">
        <div class="card-header header-elements">
            <div>
                <h5 class="card-title mb-0">Traffic Monitor</h5>
            </div>
        </div>
        @if ($pollingInterval)
        <div class="card-body" wire:poll.{{ $pollingInterval }}ms="loadTrafficData">
            @else
            <div class="card-body">
                @endif
                <canvas id="chartTraffic" wire:ignore data-upload='@json($uploadTraffic)'
                    data-download='@json($downloadTraffic)' style="min-height:300px;"></canvas>
            </div>
        </div>
    </div>

@push('scripts')

<script src="{{ asset('assets/js/backend/dashboard/chart.js') }}"></script>
<script src="{{ asset('assets/js/backend/dashboard/luxon.js') }}"></script>
<script src="{{ asset('assets/js/backend/dashboard/chartjs-adapter-luxon.js') }}"></script>
<script src="{{ asset('assets/js/backend/dashboard/chartjs-plugin-streaming.js') }}"></script>
<script src="{{ asset('assets/js/backend/dashboard/traffic-chart.js') }}"></script>
@endpush
