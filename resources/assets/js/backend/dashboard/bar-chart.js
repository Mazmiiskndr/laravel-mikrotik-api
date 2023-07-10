// Color Variables
// Assign different colors to variables for easy access
const purpleColor = '#836AF9',
  yellowColor = '#ffe800',
  cyanColor = '#28dac6',
  orangeColor = '#FF8132',
  orangeLightColor = '#FDAC34',
  oceanBlueColor = '#299AFF',
  greyColor = '#4F5D70',
  greyLightColor = '#EDF1F4',
  blueColor = '#2B9AFF',
  blueLightColor = '#84D0FF';
let cardColor, headingColor, labelColor, borderColor, legendColor;

// Check for dark style
// Depending on the style, different colors are assigned to cardColor, headingColor, labelColor, legendColor, borderColor
if (isDarkStyle) {
  cardColor = config.colors_dark.cardColor;
  headingColor = config.colors_dark.headingColor;
  labelColor = config.colors_dark.textMuted;
  legendColor = config.colors_dark.bodyColor;
  borderColor = config.colors_dark.borderColor;
} else {
  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  labelColor = config.colors.textMuted;
  legendColor = config.colors.bodyColor;
  borderColor = config.colors.borderColor;
}
// For each chart, set its height equal to its data-height attribute
const chartList = document.querySelectorAll('.chartjs');
chartList.forEach(function (chartListItem) {
  chartListItem.height = chartListItem.dataset.height;
});

let usersDataChartVar;

// Get the user's data chart element by its ID
const usersDataChart = document.getElementById('usersDataChart');
// Calculate the maximum value from usersData

if (usersDataChart) {
  // Parse users data from Laravel Blade to JS

  const maxValue = Math.max(...Object.values(usersData));
  usersDataChartVar = new Chart(usersDataChart, {
    type: 'bar',
    data: {
      labels: Object.keys(usersData),
      datasets: [
        {
          data: Object.values(usersData),
          backgroundColor: cyanColor,
          borderColor: 'transparent',
          maxBarThickness: 15,
          borderRadius: {
            topRight: 15,
            topLeft: 15
          }
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        duration: 1000,
        easing: 'easeInOutCubic'
      },
      plugins: {
        tooltip: {
          rtl: isRtl,
          backgroundColor: cardColor,
          titleColor: headingColor,
          bodyColor: legendColor,
          borderWidth: 1,
          borderColor: borderColor
        },
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          grid: {
            color: borderColor,
            drawBorder: false,
            borderColor: borderColor
          },
          ticks: {
            color: labelColor
          }
        },
        y: {
          min: 0,
          max: maxValue,
          grid: {
            color: borderColor,
            drawBorder: false,
            borderColor: borderColor
          },
          ticks: {
            stepSize: 100,
            color: labelColor
          }
        }
      }
    }
  });
}
// Event listener for when new traffic data is received
window.livewire.on('updatedChartData', function (updatedUsersData) {
  // Update labels and data
  if (usersDataChartVar) {
    usersDataChartVar.data.labels = Object.keys(updatedUsersData);
    usersDataChartVar.data.datasets[0].data = Object.values(updatedUsersData);

    // Update the chart
    usersDataChartVar.update('quiet');
  }
});
