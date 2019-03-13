function inputButtonsManage() {
    let inputData;
    $("#inputForm").click(function(e) {
        console.log(e.target.id);
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
                return;
        }
        let make = $("#makeList").val();
        inputData.make = make;
        console.log(inputData);
        printChart(inputData);
    });
}

function printChart(inputData) {
    dataMapMSLoad("/mapChart/loadDataMS", inputData);
    mapChartDetailsCssUpdate(inputData);
    checkBoxLineChart("#lineChartForMap", inputData);
}


