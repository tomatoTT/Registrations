function dataMapLoad(urlList, siteTitle) {
    let url = urlList[siteTitle],
        inputData = inputDataSet();
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        async: false,
        success: function(data) {
            switch(siteTitle) {
                case "Map MS":
                    dataMapMSCss(data);
                    return;
                case "Map TIV":
                    dataMapTivCss(data);
                    return;
                case "Map TOP":
                    dataMapTopCss(data);
                    makeTopSelect(data);
                    return;
            }          
        },
        beforeSend: function() {
            $("#loadingImage").show();
        },
        complete: function() {
            $("#loadingImage").hide();
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}