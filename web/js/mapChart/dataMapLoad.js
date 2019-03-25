function dataMapLoad(urlList, inputData, siteTitle) {
    let url = urlList[siteTitle];
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
            switch(siteTitle) {
                case "Map MS":
                    let ms = dataMapMS(data);
                    dataMapMSCss(ms);
                    mapKeyMS(ms);
                    mapKeyTitleMS(data);
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
            $("h1").show();
        },
        complete: function() {
            $("h1").hide();
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}