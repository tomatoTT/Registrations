/*Generate input buttons*/
function createInputMapChart(input=Array, inputSelector, urlSliderRange, urlMakeLIst) {
    if (Array.isArray(input)) {
        for (var i=0; i<input.length; i++) {            
            if (input[i] === "Make") {                
                makeListLoad(urlMakeLIst, inputSelector);
                $("#makeList").after('<button id="makeSubmit">Wybierz</button></br>');
            } else {
                $(inputSelector).append('<input id="'+input[i]+'" class="inputButton" type="button" value="'+input[i]+'">');
            };
        }        
    }
    $(inputSelector).append('<input id="lineChartForMap" type="checkbox"/>');    
    $("#Accept").hide();
}

function createMakeInputButtons(data, inputSelector) {
    var option = "";
    data.sort();
    for (var i=0; i<data.length; i++) {
        option += '<option id="makeListSelect" class="makeListSelect" value="'+data[i]+'">'+data[i]+'</option>';
    }
    $(inputSelector).append(
        '<select id="makeList">'+option+'</seclect>'
    );
    $("#makeList").val("JOHNDEERE");
}

function sliderRangeLoad(url, selector) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(data) {
            let max = rangeArray(data), dates = rangeDates(max, data);
            rangeSlider(selector, max, dates);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function rangeSlider(selector, maximum, dates) {
    $(selector).slider({
        range: true,
        min: 1,
        max: maximum,
        values: valuesForSlider(dates),
        slide: function(event, ui) {
            let inputData = {
                regYearMin: dates[ui.values[0]].split('.')[1],
                regMonthMin: dates[ui.values[0]].split('.')[0],
                regYearMax: dates[ui.values[1]].split('.')[1],
                regMonthMax: dates[ui.values[1]].split('.')[0]
            };
            updateDateRange(inputData);
        }
    });
}

function rangeArray(data) {
    var rangeNum;
    if (data.yearMin === data.yearMax) {
        rangeNum = (13 - parseInt(data.monthMin)) + parseInt(data.monthMax);
        return rangeNum;
    }
    rangeNum = (13 - parseInt(data.monthMin)) + 
            ((parseInt(data.yearMax) - parseInt(data.yearMin) - 1) * 12) + 
            parseInt(data.monthMax);
    return rangeNum;
}

function rangeDates(max, data) {
    let i, dates = [], counterMonth = parseInt(data.monthMin), counterYear = parseInt(data.yearMin);
    for (i=1; i<=max; i++) {
        if (counterMonth <= 12) {
            dates[i] = counterMonth+'.'+counterYear;
            counterMonth++;
        } else {
            counterMonth = 1;
            counterYear++;
            i--;
        }
    }
    return dates;
}

function makeListLoad(url, inputSelector) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        async: false,
        success: function(data) {
            createMakeInputButtons(data, inputSelector);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function valuesForSlider(dates) {
    let values = [
        dates.indexOf($("#regMonthMin").text()+'.'+$("#regYearMin").text()),
        dates.indexOf($("#regMonthMax").text()+'.'+$("#regYearMax").text())
    ];
    return values;
}