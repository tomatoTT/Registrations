function ytd() {
    var today = new Date(), yearMin, monthMin, yearMax, monthMax, inputData = {};    
    if (today.getMonth() === 0) {
        yearMin = today.getFullYear() -1;
        monthMin = 1;
        yearMax = today.getFullYear() -1;
        monthMax = 12;
    } else {
        yearMin = today.getFullYear();
        monthMin = 1;
        yearMax = today.getFullYear();
        monthMax = today.getMonth();
    }    
    inputData = {
        regYearMin: yearMin,
        regMonthMin: monthMin,
        regYearMax: yearMax,
        regMonthMax: monthMax,
        make: "",
        county: ""
    };    
    return inputData;
}

function rolling12() {
    var today = new Date(), yyyyMax, mmMax, yyyyMin, mmMin, inputData = {};
    if (today.getMonth() === 0) {
        yyyyMin = today.getFullYear() - 1;
        yyyyMax = today.getFullYear() - 1;
        mmMin = 1;
        mmMax = 12;
    } else {
        yyyyMin = today.getFullYear() -1;
        yyyyMax = today.getFullYear();
        mmMin = today.getMonth() + 1;
        mmMax = today.getMonth();
    }                 
    inputData = {
        regYearMin: yyyyMin,
        regMonthMin: mmMin,
        regYearMax: yyyyMax,
        regMonthMax: mmMax,
        make: "",
        county: ""
    };
    return inputData;
}

function qtd() {
    var today = new Date(), yyyyMax, mmMax, yyyyMin, mmMin, inputData = {};
    if (today.getMonth() === 0) {
        yyyyMin = today.getFullYear() - 1;
        yyyyMax = today.getFullYear() - 1;
        mmMin = 10;
        mmMax = 12;
    } else {
        yyyyMin = today.getFullYear();
        yyyyMax = today.getFullYear();
        if (today.getMonth()>0 && today.getMonth()<4) {
            mmMin = 1;
            mmMax = today.getMonth();
        } else if (today.getMonth()>3 && today.getMonth()<7) {
            mmMin = 4;
            mmMax = today.getMonth();
        } else if (today.getMonth()>6 && today.getMonth()<10) {
            mmMin = 7;
            mmMax = today.getMonth();
        } else {
            mmMin = 10;
            mmMax = today.getMonth();
        }        
    }
    inputData = {
        regYearMin: yyyyMin,
        regMonthMin: mmMin,
        regYearMax: yyyyMax,
        regMonthMax: mmMax,
        make: "",
        county: ""
    };
    return inputData;
}
    
function rolling3() {
    var today = new Date(), yyyyMax, mmMax, yyyyMin, mmMin, inputData = {};
    if (today.getMonth() === 0) {
        yyyyMin = today.getFullYear() - 1;
        yyyyMax = today.getFullYear() - 1;
        mmMin = 10;
        mmMax = 12;
    } else if (today.getMonth()>0 && today.getMonth()<3) {
            yyyyMin = today.getFullYear() - 1;
            yyyyMax = today.getFullYear();
            mmMin = 12 - (2 - today.getMonth());
            mmMax = today.getMonth();
    } else {
        yyyyMin = today.getFullYear();
        yyyyMax = today.getFullYear();
        mmMin = today.getMonth() - 2;
        mmMax = today.getMonth();
    }
    inputData = {
        regYearMin: yyyyMin,
        regMonthMin: mmMin,
        regYearMax: yyyyMax,
        regMonthMax: mmMax,
        make: "",
        county: ""
    };
    return inputData;
}