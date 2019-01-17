function createInputMapChart(input=Array, selector, url) {
    /*Generate input buttons*/
    if (Array.isArray(input)) {
        for (var i=0; i<input.length; i++) {
            $("#inputForm").append('<button id="'+input[i]+'" class="inputButton">'+input[i]+'</button></br>');
        }        
    }
    slideRangeLoad(url, selector);
    $(selector).hide();
    $("#"+input[i - 1]).click(function(){
        $(selector).toggle();
    });    
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
            console.log(rangeDates(max, data));
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
            console.log(ui.values);
            console.log(maximum);

            $("#rangeDate").val(dates[ui.values[0]] + " " + dates[ui.values[1]])
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