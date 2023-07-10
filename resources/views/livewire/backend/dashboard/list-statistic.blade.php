{{-- <div class="col-xl-12 mb-4 col-lg-12 col-12">
    <div class="card h-100">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title mb-0">Statistics</h3>
            </div>
        </div>
        @if ($pollingInterval)
        <div class="card-body" wire:poll.{{ $pollingInterval }}ms="loadData">
            @else
            <div class="card-body">
                @endif
                <div class="row gy-3">

                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                <i class="fa-solid fa-server ti-sm"></i>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0" id="cpuLoad">{{ $cpuLoad }}</h5>
                                <small>CPU Load</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                <i class="fa-solid fa-network-wired ti-sm"></i>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0" id="activeHotspots">{{ $activeHotspots }}</h5>
                                <small>Hotspot Active</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                <i class="fa-solid fa-clock ti-sm"></i>
                            </div>
                            <div class="card-info">
                                <!-- Add id "uptime" to the h5 element -->
                                <h5 id="uptime" class="mb-0">{{ $uptime }}</h5>
                                <small>Uptime</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-google-plus me-3 p-2">
                                <i class="fa-solid fa-memory ti-sm"></i>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0" id="freeMemoryPercentage">{{ $freeMemoryPercentage }}</h5>
                                <small>Free Memory</small>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div> --}}
{{-- TODO: --}}
<div class="row" wire:poll.{{ $pollingInterval }}ms="loadData">
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="card-title text-center mb-0">CPU Load</h5>
                {{-- <small class="text-muted">Expenses</small> --}}
            </div>
            <div class="card-body" style="position: relative;" >
                <div id="cpuChart" style="min-height: 76px;" data-cpuLoad="{{ $cpuLoad }}"></div>
                <div class="resize-triggers">
                    <div class="expand-trigger">
                        <div style="width: 183px; height: 161px;"></div>
                    </div>
                    <div class="contract-trigger"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="badge rounded-pill p-2 bg-label-danger mb-2">
                    <i class="fa-solid fa-network-wired ti-sm"></i>
                </div>
                <h5 class="card-title mb-2">Hotspot Active</h5>
                <small>{{ $activeHotspots }}</small>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body pt-4">
                <div class="d-flex justify-content-between align-items-center mb-2 gap-3 pt-1">
                    <h6 class="mb-0">Free Memory</h6>
                    <div class="badge bg-label-success">+{{ $freeMemoryPercentage }}</div>
                </div>
                <div class="d-flex justify-content-between gap-3">
                    <span class="text-muted">{{ $freeMemoryPercentage }}</span>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <div class="progress w-100" style="height: 8px">
                        <div class="progress-bar bg-primary" style="width: {{ $freeMemoryPercentage }}" role="progressbar"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="card-title mb-3">System Info</h5>
                {{-- <small class="text-muted">Expenses</small> --}}
            </div>
            <div class="card-body" style="padding: 0.5rem">

                <table class="table table-borderless table-hover" >
                    <tr>
                        <th>Uptime</th>
                        <th>:</th>
                        <td>{{ $uptime }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
    const cpuLoadElement = document.getElementById('cpuChart');
    const cpuLoad = parseInt(cpuLoadElement.getAttribute('data-cpuLoad'), 10);
    let color = 'rgba(0,255,0,0.85)';
    const expensesRadialChartEl = document.querySelector('#cpuChart'),
    expensesRadialChartConfig = {
      chart: {
        height: 145,
        sparkline: {
          enabled: true
        },
        parentHeightOffset: 0,
        type: 'radialBar'
      },
      colors: [color],
      series: [cpuLoad],
      plotOptions: {
        radialBar: {
          offsetY: 0,
          startAngle: -90,
          endAngle: 90,
          hollow: {
            size: '65%'
          },
          track: {
            strokeWidth: '45%',
            background: 'rgba(79,93,112,0.5)'
          },
          dataLabels: {
            name: {
              show: false
            },
            value: {
              fontSize: '22px',
              color: '#4F5D70',
              fontWeight: 600,
              offsetY: -5
            }
          }
        }
      },
      grid: {
        show: false,
        padding: {
          bottom: 5
        }
      },
      stroke: {
        lineCap: 'round'
      },
      labels: ['Progress'],
      responsive: [
        {
          breakpoint: 1442,
          options: {
            chart: {
              height: 100
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '55%'
                },
                dataLabels: {
                  value: {
                    fontSize: '16px',
                    offsetY: -1
                  }
                }
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            chart: {
              height: 228
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '75%'
                },
                track: {
                  strokeWidth: '50%'
                },
                dataLabels: {
                  value: {
                    fontSize: '26px'
                  }
                }
              }
            }
          }
        },
        {
          breakpoint: 890,
          options: {
            chart: {
              height: 180
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '70%'
                }
              }
            }
          }
        },
        {
          breakpoint: 426,
          options: {
            chart: {
              height: 142
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '70%'
                },
                dataLabels: {
                  value: {
                    fontSize: '22px'
                  }
                }
              }
            }
          }
        },
        {
          breakpoint: 376,
          options: {
            chart: {
              height: 105
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '60%'
                },
                dataLabels: {
                  value: {
                    fontSize: '18px'
                  }
                }
              }
            }
          }
        }
      ]
    };
  if (typeof expensesRadialChartEl !== undefined && expensesRadialChartEl !== null) {
    const expensesRadialChart = new ApexCharts(expensesRadialChartEl, expensesRadialChartConfig);
    expensesRadialChart.render();

    // Listen to livewire event for data updates
    window.livewire.on('dataUpdated', data => {
        let color;
        switch (data.color) {
            case 'green':
                color = 'rgba(0,255,0,0.85)';
                break;
            case 'orange':
                color = 'rgba(255,165,0,0.85)';
                break;
            case 'red':
                color = 'rgba(255,0,0,0.85)';
                break;
        }
        // Update chart color and data
        expensesRadialChart.updateOptions({
            series: [data.cpuLoad],
            colors: [color],
        });
    });


}
</script>
@endpush
