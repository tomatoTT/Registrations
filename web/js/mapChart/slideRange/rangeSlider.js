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


