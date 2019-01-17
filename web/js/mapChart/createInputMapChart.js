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

            rangeSlider(selector, data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function rangeSlider(selector, data) {
    $(selector).slider({
        range: true,
        min: 1,
        max: rangeArray(data),
        values: [1, 12],
        slide: function( event, ui ) {
            console.log(ui.values);
            console.log(rangeArray(data));
            $("#rangeDate").val(ui.values[ 0 ] + " " + ui.values[ 1 ])
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