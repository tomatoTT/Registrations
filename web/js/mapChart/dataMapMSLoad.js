function dataMapMSLoad(url, inputData) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
            var ms = dataMapMS(data);
            dataMapMSCss(ms);
            mapKey(ms);
            mapKeyTitle(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}