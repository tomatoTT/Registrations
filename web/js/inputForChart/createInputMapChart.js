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
    $("#Customize").click(function(){        
        if ($("#slider-range").length) {
            console.log($("#slider-range"));
            $("#Accept").toggle();
            $("#slider-range").remove();
        } else {
            console.log("czy to");
            $("#Accept").toggle();
            $("#sliderContainer").append('<div id="slider-range"></div>');
            sliderRangeLoad(urlSliderRange, "#slider-range");
        }        
    });
}

function createMakeInputButtons(data, inputSelector) {
    var option = "";
    data.sort();
    for (var i=0; i<data.length; i++) {
        option += '<option class="makeListSelect" value="'+data[i]+'">'+data[i]+'</option>';
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
            $("#regYearMin").text(dates[ui.values[0]].split('.')[1]);
            $("#regMonthMin").text(dates[ui.values[0]].split('.')[0]);
            $("#regYearMax").text(dates[ui.values[1]].split('.')[1]);
            $("#regMonthMax").text(dates[ui.values[1]].split('.')[0]);
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
    console.log(dates[values[0]].split('.'));
    console.log(values);
    return values;
}