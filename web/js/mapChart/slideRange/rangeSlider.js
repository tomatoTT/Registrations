function rangeSlider(selector, data) {
    $(selector).slider({
        range: true,
        slide: function( event, ui ) {
            console.log(ui.values);
        }
    });
}

