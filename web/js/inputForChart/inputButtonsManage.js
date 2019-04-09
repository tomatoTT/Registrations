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
                $("#Accept").prop("disabled", true);
                printChart(urlList, inputData, siteTitle);
                return;
            case "Customize":
                customizeBehavior();
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
            case "inputButtons":
                return;
        }
        $("#inputForm").children().prop("disabled", false);
        $("#"+e.target.id).not("#Accept").prop("disabled", true);
        updateDateRange(inputData);
        printChart(urlList, inputData, siteTitle);
        console.log(e.target.id);
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

function customizeBehavior() {       
    if ($("#slider-range").length) {
        $("#Accept").toggle();
        $("#slider-range").remove();
        $("#inputForm").children().prop("disabled", false);
    } else {
        $("#Accept").toggle();
        $("#inputButtons").children().not("#Accept, #Customize").prop("disabled", true);
        $("#sliderContainer").append('<div id="slider-range"></div>');
        sliderRangeLoad("/mapChart/slideRangeSource", "#slider-range");
    }
}

function acceptCustomizeSelect() {
        $("#Accept").prop("disabled", true);
}