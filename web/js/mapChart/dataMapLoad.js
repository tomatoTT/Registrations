function dataMapLoad(urlList, siteTitle) {
    let url = urlList[siteTitle],
        inputData = inputDataSet();
        inputData.make = $("#makeList").val();;
        console.log($("#makeList"));
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
            switch(siteTitle) {
                case "Map MS":
                    console.log(data);
                    let ms = dataMapMS(data);
                    console.log(ms);
                    dataMapMSCss(ms);
                    mapKeyMS(ms);
                    mapKeyTitleMS(data);
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