function chartDraw(chartId, labels, data) {

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
                    position: 'left'
                }, {
                    id: 'B',
                    type: 'linear',
                    position: 'right'
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

