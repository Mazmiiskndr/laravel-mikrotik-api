var donutChart;
document.addEventListener('DOMContentLoaded', function () {
  var chartElement = document.getElementById('userActiveChart');
  var data = JSON.parse(chartElement.getAttribute('data-chart'));

  if (data) {
    var donutChartEl = chartElement;
    var donutChartConfig = {
      chart: {
        height: 410,
        type: 'donut'
      },
      labels: ['Active Users', 'Bypasseds', 'Blockeds'],
      series: [data.userActive, data.ipBindingBypassed, data.ipBindingBlocked],
      colors: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
      legend: {
        show: true,
        position: 'top',
        markers: { offsetX: -3 },
        itemMargin: {
          vertical: 3,
          horizontal: 10
        }
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                fontSize: '2rem',
                fontFamily: 'Open Sans'
              },
              value: {
                fontSize: '1.2rem',
                color: 'rgba(54, 162, 235, 1)',
                fontFamily: 'Open Sans',
                formatter: function (val) {
                  return val;
                }
              },
              total: {
                show: true,
                fontSize: '1.5rem',
                color: 'rgba(54, 162, 235, 1)',
                label: 'Active Users',
                formatter: function (w) {
                  return data.userActive;
                }
              }
            }
          }
        }
      },
      responsive: [
        {
          breakpoint: 992,
          options: {
            chart: {
              height: 380
            },
            legend: {
              show: true,
              position: 'top'
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              height: 320
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      fontSize: '1.5rem'
                    },
                    value: {
                      fontSize: '1rem'
                    },
                    total: {
                      fontSize: '1.5rem'
                    }
                  }
                }
              }
            },
            legend: {
              position: 'top',
              labels: {
                colors: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                useSeriesColors: false
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            chart: {
              height: 280
            },
            legend: {
              show: false
            }
          }
        },
        {
          breakpoint: 360,
          options: {
            chart: {
              height: 250
            },
            legend: {
              show: false
            }
          }
        }
      ]
    };

    if (typeof donutChartEl !== undefined && donutChartEl !== null) {
      donutChart = new ApexCharts(donutChartEl, donutChartConfig); // Modify this line
      donutChart.render();
    }
  }
});
window.addEventListener('chartDataUpdated', e => {
  if (donutChart) {
    donutChart.updateOptions({
      labels: ['Active Users', 'Bypasseds', 'Blockeds'],
      series: [e.detail.userActive, e.detail.ipBindingBypassed, e.detail.ipBindingBlocked],
      plotOptions: {
        pie: {
          donut: {
            labels: {
              total: {
                formatter: function (w) {
                  return e.detail.userActive;
                }
              }
            }
          }
        }
      }
    });
  }
});
