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


