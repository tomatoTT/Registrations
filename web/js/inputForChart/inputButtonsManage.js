function inputButtonsManage(urlList, inputData, siteTitle) {
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
            case "submitCustomDates":
                inputData = customize("#hiddenRangeDate");
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
        printChart(urlList, inputData, siteTitle);
    });
    return inputData;
}

function printChart(urlList, inputData, siteTitle) {
    inputData.make = $("#makeList").val();
    console.log(inputData);
    dataMapLoad(urlList, inputData, siteTitle);
    mapChartDetailsCssUpdate(inputData);
    checkBoxLineChart("#lineChartForMap", inputData);
}