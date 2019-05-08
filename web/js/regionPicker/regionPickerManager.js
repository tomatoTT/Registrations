function regionLoad(url, input) {
    $.ajax({
        type: 'POST',
        url: url,
        data: input,
        dataType: 'json',
        async: false,
        success: function(data) {
            
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}