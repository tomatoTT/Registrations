function createInputMapChart(input=Array, inputSelector, sliderSelector, url) {
    /*Generate input buttons*/
    if (Array.isArray(input)) {
        for (var i=0; i<input.length; i++) {
            $(inputSelector).append('<button id="'+input[i]+'" class="inputButton">'+input[i]+'</button></br>');
        }        
    }
    createSliderButtons(sliderSelector);
    slideRangeLoad(url, sliderSelector);
    $(sliderSelector).hide();
    $("#"+input[i - 1]).click(function(){
        $(sliderSelector).toggle();
    });    
}

function createSliderButtons(selector) {
    $(selector).append('<p><label for = "rangeDate">Zakres dat:</label>\n\
                        <input type = "text" id = "rangeDate" value = "1/2007 12/2007">\n\
                        <input type = "hidden" id = "hiddenRangeDate" value = "1/2007/12/2007">\n\
                        <button id ="submitCustomDates">Akceptuj</button></p>');
}

function createMakeInput() {
    
}

function slideRangeLoad(url, selector) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(data) {
            var max = rangeArray(data);
            var dates = rangeDates(max, data);
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
        values: [1, 12],
        slide: function( event, ui ) {
            $("#rangeDate").val(dates[ui.values[0]] + " " + dates[ui.values[1]]);
            $("#hiddenRangeDate").val(dates[ui.values[0]] + "/" + dates[ui.values[1]]);
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
    var dates = [];
    var counterMonth = parseInt(data.monthMin);
    var counterYear = parseInt(data.yearMin);
    for (var i=1; i<=max; i++) {
        if (counterMonth <= 12) {
            dates[i] = counterMonth+"/"+counterYear;
            counterMonth++;
        } else {
            counterMonth = 1;
            counterYear++;
            i--;
        }
    }
    return dates;
}

function makeListLoad(url) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(data) {
            console.log(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}