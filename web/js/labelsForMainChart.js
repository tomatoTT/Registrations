/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function labelsForMainChart(data) {
    
    var labels = [];
    var label = "";
    
    for (i=0; i<data.length; i++) {
        
        labels.push(label.concat(data[i].regMonth, "/", data[i].regYear));
    }
    
    return labels;
}


