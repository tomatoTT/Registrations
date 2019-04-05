function dataMapLoad(urlList, siteTitle) {
    let url = urlList[siteTitle],
        inputData = inputDataSet();
        console.log(inputData);
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
            switch(siteTitle) {
                case "Map MS":
                    console.log(data);
                    dataMapMSCss(data);
                    return;
                case "Map TIV":
                    console.log(data);
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