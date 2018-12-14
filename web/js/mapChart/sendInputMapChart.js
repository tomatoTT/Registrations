function ytd() {
    var today = new Date();
    var yearMin;
    var monthMin;
    var yearMax;
    var monthMax;
    var inputData = {};    
    if (today.getMonth() === 1) {
        yearMin = today.getFullYear() -1;
        monthMin = 1;
        yearMax = today.getFullYear() -1;
        monthMax = 12;
    } else {
        yearMin = today.getFullYear();
        monthMin = 1;
        yearMax = today.getFullYear();
        monthMax = today.getMonth() - 1;
    }
    
    inputData = {
        regYearMin: yearMin,
        regMonthMin: monthMin,
        regYearMax: yearMax,
        regMonthMax: monthMax
    };    
    return inputData;
}

function rolling12() {
    var today = new Date();
    var yyyyMax;
    var mmMax;
    var yyyyMin;
    var mmMin;
    var inputData = {};
    if (today.getMonth() === 1) {
        yyyyMin = today.getFullYear() - 1;
        yyyyMax = today.getFullYear() - 1;
        mmMin = 1;
        mmMax = 12;
    } else {
        yyyyMin = today.getFullYear() -1;
        yyyyMax = today.getFullYear();
        mmMin = today.getMonth();
        mmMax = today.getMonth() -1;
    }                 
    inputData = {
        regYearMin: yyyyMin,
        regMonthMin: mmMin,
        regYearMax: yyyyMax,
        regMonthMax: mmMax
    };
    return inputData;
}


