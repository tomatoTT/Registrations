/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function labelsForMainChart(data) {
    
    var labels = [];
    var label = "";
    var yearMin = data[0].regYear;
    var yearMax = data[0].regYear;;
    var monthYearMin = data[0].regMonth;
    var monthYearMax = data[0].regMonth;

    
    for (i=0; i<data.length; i++) {
        
        if (yearMin > data[i].regYear) {            
            yearMin = data[i].regYear;           
        }
        
        if (yearMax < data[i].regYear) {            
            yearMax = data[i].regYear;           
        }
    }
    
    for (i=0; i<data.length; i++) {
        
        if (yearMin === data[i].regYear && monthYearMin < data[i].regMonth) {
            monthYearMin = data[i].regMonth;
        }
        
        if (yearMax === data[i].regYear && monthYearMax < data[i].regMonth) {
            monthYearMax = data[i].regMonth;
        }        
    }
    
    for (i=monthYearMin; i<=12; i++) {
            labels.push(label.concat(yearMin, "/", i));
        }
    
    for (i=yearMin+1; i<=yearMax-1; i++) {
        for (j=1; j<=12; j++) {
            labels.push(label.concat(j, "/", i));
        }
    }
    if (yearMin !== yearMax) {
        for (i=1; i<=monthYearMax; i++) {
                labels.push(label.concat(yearMax, "/", i));
            }
    }
    console.log(yearMin);
    console.log(monthYearMin);
    
    console.log(yearMax);
    console.log(monthYearMax);
    
    
    console.log(labels);
    return labels;
}


