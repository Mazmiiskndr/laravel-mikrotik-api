@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.min.css') }}" />
@endpush
<div class="row">
    <div class="col-xl-12">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#tabMonitoring" aria-controls="tabMonitoring" aria-selected="true">
                    <i class="tf-icons fas fa-tv ti-xs me-1"></i> Monitoring
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#tabNetworkOverview" aria-controls="tabNetworkOverview" aria-selected="false">
                    <i class="tf-icons fas fa-network-wired ti-xs me-1"></i> Network Overview
                </button>
            </li>
        </ul>

        <div class="tab-content" style="background-color: transparent;padding: 0;border: none !important">
            <div class="tab-pane fade show active" id="tabMonitoring" role="tabpanel">

                @if($isAllowedToAdministrator)
                @livewire('backend.dashboard.list-statistic')
                @endif

                {{-- START CHART --}}
                <!-- Line Charts -->
                <div class="row">
                    @livewire('backend.dashboard.line-chart')
                </div>

                <!-- Polar Area Chart -->
                <div class="row">
                    @livewire('backend.dashboard.polar-chart')

                    {{-- TODO: bar chart --}}
                    @livewire('backend.dashboard.bar-chart')

                </div>

                {{-- END CHART --}}
            </div>

            <div class="tab-pane fade" id="tabNetworkOverview" role="tabpanel">
                {{-- START DATATABLES --}}
                <!-- Datatables DHCP Leases Data -->
                @livewire('backend.dashboard.data-table')
                {{-- END DATATABLES --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/backend/dashboard/bar-chart.js') }}"></script>
@endpush

@endsection
