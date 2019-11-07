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
                acceptCustomizeSelect(urlList, siteTitle);
                return;
            case "Customize":
                customizeBehavior();
                return;
            case "lineChartForMap":
                checkBoxLineChart("#lineChartForMap", inputData);
                return;
            case "makeSubmit":
                dataMapLoad(urlList, siteTitle);
                return;
            case "makeList":
                return;
            case "inputForm":
                return;
            case "makeListSelect":
                return;
            case "inputButtons":
                return;
            case "slider-range":
                return;
            case "makeListSelect":
                return;
            case "combineCounty":
                checkBoxCombineCounty("#combineCounty");
                return;
        }
        $("#inputButtons").children().prop("disabled", false);
        $("#"+e.target.id).prop("disabled", true);
        updateDateRange(inputData);
        printChart(urlList, siteTitle);
    });    
}

function printChart(urlList, siteTitle) {
    dataMapLoad(urlList, siteTitle);
    mapChartDetailsCssUpdate();
    checkBoxLineChart("#lineChartForMap");
}

function updateDateRange(inputData) {
     $("#regYearMin").text(inputData.regYearMin);
     $("#regMonthMin").text(inputData.regMonthMin);
     $("#regYearMax").text(inputData.regYearMax);
     $("#regMonthMax").text(inputData.regMonthMax);
}

function customizeBehavior() {
    let inputData;
    if ($("#slider-range").length) {
        inputData = {
            regYearMin: $("#regYearMinHidden").text(),
            regMonthMin: $("#regMonthMinHidden").text(),
            regYearMax: $("#regYearMaxHidden").text(),
            regMonthMax: $("#regMonthMaxHidden").text(),
            make: $("#makeList").val(),
            county: ""
        };
        updateDateRange(inputData);
        $("#Accept").toggle();
        $("#slider-range").remove();
        $("#inputButtons").children().prop("disabled", false);
    } else {
        $("#Accept").toggle();
        $("#inputButtons").children().not("#Accept, #Customize").prop("disabled", true);
        $("#sliderContainer").append('<div id="slider-range"></div>');
        sliderRangeLoad("/mapChart/slideRangeSource", "#slider-range");
        inputData = inputDataSet();
        $("#slider-range").append('<div id="dateRangeHidden" hidden>\n\
                                    <p id="regMonthMinHidden">1</p>\n\
                                    <p id="regYearMinHidden">2017</p>\n\
                                    <p id="regMonthMaxHidden">12</p>\n\
                                    <p id="regYearMaxHidden">2017</p></div>');
        updateDateRangeHidden(inputData);
    }
}

function acceptCustomizeSelect(urlList, siteTitle) {
    $("#Accept").toggle();
    $("#slider-range").remove();
    $("#inputButtons").children().prop("disabled", false);
    printChart(urlList, siteTitle);
}

function updateDateRangeHidden(inputData) {
     $("#regYearMinHidden").text(inputData.regYearMin);
     $("#regMonthMinHidden").text(inputData.regMonthMin);
     $("#regYearMaxHidden").text(inputData.regYearMax);
     $("#regMonthMaxHidden").text(inputData.regMonthMax);
}