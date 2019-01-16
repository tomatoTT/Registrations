function rangeSlider(selector, data) {
    $(selector).slider({
        range: true,
        slide: function( event, ui ) {
            console.log(ui.values);
        }
    });
}

function rangeArray(data) {
    if (data[0].yearMin === data[0].yearMax) {
        var rangeNum = data[0].monthMax - data[0].monthMin + 1;
        var labels = array();
        for (var i=0; i<=rangeNum; i++) {
            
        }
    }
}

