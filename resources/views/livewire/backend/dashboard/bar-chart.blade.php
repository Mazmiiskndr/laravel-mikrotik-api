<!-- Bar Charts -->
<div class="col-lg-6 col-12 mb-4">
    <div class="card">
        <div class="card-header header-elements">
            <h5 class="card-title mb-0">Total Access Users Data <small>(Last 30 Days)</small></h5>
            <div class="card-action-element ms-auto py-0">
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ti ti-calendar"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->subMonth()->format('Y-m-d') }}', '{{ now()->format('Y-m-d') }}')">Last
                                30 Days</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->subWeek()->format('Y-m-d') }}', '{{ now()->format('Y-m-d') }}')">Last
                                7 Days</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->subDay()->format('Y-m-d') }}', '{{ now()->subDay()->format('Y-m-d') }}')">Yesterday</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->format('Y-m-d') }}', '{{ now()->format('Y-m-d') }}')">Today</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->startOfMonth()->format('Y-m-d') }}', '{{ now()->endOfMonth()->format('Y-m-d') }}')">Current
                                Month</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"
                                wire:click="updateChartData('{{ now()->subMonth()->startOfMonth()->format('Y-m-d') }}', '{{ now()->subMonth()->endOfMonth()->format('Y-m-d') }}')">Last
                                Month</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="usersDataChart" class="chartjs" data-height="400"></canvas>
        </div>
    </div>
</div>
<!-- /Bar Charts -->
@push('scripts')

{{-- <script src="{{ asset('assets/js/charts-chartjs.js') }}"></script> --}}
<script>
    var usersData = @json($usersData);

</script>
@endpush
