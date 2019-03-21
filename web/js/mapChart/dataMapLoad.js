function dataMapLoad(urlList, inputData, siteTitle) {
    let url;
    switch(siteTitle) {
        case "Map MS":
            url = urlList[siteTitle];
            break;
    }
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


