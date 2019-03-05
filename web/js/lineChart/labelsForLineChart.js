function labelsForLineChart(inputData) {    
    var labels = [],
        label = "",
        yearMin = inputData.regYearMin,
        yearMax = inputData.regYearMax,
        monthYearMin = inputData.regMonthMin,
        monthYearMax = inputData.regMonthMax;
    if (yearMin !== yearMax) {
        for (var i=monthYearMin; i<=12; i++) {
            labels.push(label.concat(yearMin, "/", i));
        }
        for (var i=yearMin+1; i<=yearMax-1; i++) {
            for (var j=1; j<=12; j++) {
                labels.push(label.concat(i, "/", j));
            }
        }
        for (var i=1; i<=monthYearMax; i++) {
                labels.push(label.concat(yearMax, "/", i));
            }
    } else {
        for (var i=monthYearMin; i<=monthYearMax; i++) {
            labels.push(label.concat(yearMin, "/", i));
        }
    }
    return labels;
}