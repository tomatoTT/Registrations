function slideRangeLoad(url) {
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


