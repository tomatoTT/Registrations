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
            datasets: [{
                label: 'A',
                yAxisID: 'A',
                data: units,
                backgroundColor: [
                    'rgba(255, 99, 132, 0)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)'
                ],
                borderWidth: 2
            }, {
                label: 'B',
                yAxisID: 'B',
                data: [5, 10, 7, 15, 20, 10],
                backgroundColor: [
                    'rgba(200, 99, 132, 0)'
                ],
                borderColor: [
                    'rgba(200,99,132,1)'
                ],
                borderWidth: 1                        
            }]
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

