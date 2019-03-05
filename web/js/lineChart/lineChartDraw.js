function lineChartDraw(chartId, labels, data) {
    var ctx = document.getElementById(chartId);
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: chartDrawDatasets(data, labels)
        },
        options: {
            scales: {
                yAxes: [{
                    id: 'A',
                    type: 'linear',
                    position: 'right',
                    ticks: {beginAtZero: true}
                }, {
                    id: 'B',
                    type: 'linear',
                    position: 'left',
                    ticks: {beginAtZero: true}
                }]
            },
            legend: {
                labels: {
                    usePointStyle: false
                }
            }
        }                
    });
}