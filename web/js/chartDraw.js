/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function chartDraw (chartId, labels) {
    var ctx = document.getElementById(chartId);
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: chartDrawDatasets(data)
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
            }
        }                
    });
}

