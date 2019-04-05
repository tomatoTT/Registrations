function inputButtonsManage(urlList, siteTitle) {
    let inputData = inputDataSet();
    $("#inputForm").click(function(e) {
        switch(e.target.id) {
            case "YTD":
                inputData = ytd();
                break;
            case "Rolling12":
                inputData = rolling12() ;
                break;
            case "QTD":
                inputData = qtd();
                break;
            case "Rolling3":
                inputData = rolling3();
                break;
            case "Accept":
                inputData = inputDataSet();
                break;
            case "Customize":
                return;
            case "lineChartForMap":
                checkBoxLineChart("#lineChartForMap", inputData);
                return;
            case "makeSubmit":
                break;
            case "makeList":
                return;
            case "inputForm":
                return;
            case "makeListSelect":
                return;
        }
        $("#inputForm").children().prop("disabled", false);
        $("#"+e.target.id).prop("disabled", true);
        updateDateRange(inputData);
        printChart(urlList, inputData, siteTitle);  
    });    
}

function printChart(urlList, inputData, siteTitle) {
    dataMapLoad(urlList, siteTitle);
    mapChartDetailsCssUpdate(inputData);
    checkBoxLineChart("#lineChartForMap", inputData);
}

function updateDateRange(inputData) {
     $("#regYearMin").text(inputData.regYearMin);
     $("#regMonthMin").text(inputData.regMonthMin);
     $("#regYearMax").text(inputData.regYearMax);
     $("#regMonthMax").text(inputData.regMonthMax);
}