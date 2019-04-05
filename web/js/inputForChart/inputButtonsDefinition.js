function inputButtonsDefinition(siteTitle) {
    let input;
    switch(siteTitle) {
        case "Map MS":
            input =  [
                "Make",
                "YTD",
                "Rolling12",
                "QTD",
                "Rolling3",
                "Customize",
                "Accept"
            ];
            break;
        case "Map TIV":
            input = [
                "YTD",
                "Rolling12",
                "QTD",
                "Rolling3",
                "Customize",
                "Accept"
            ];
            break;
        case "Map TOP":
            input = [
                "YTD",
                "Rolling12",
                "QTD",
                "Rolling3",
                "Customize",
                "Accept"
            ];
            break;
    }
    createInputMapChart(
        input, 
        "#inputForm",
        "/mapChart/slideRangeSource", 
        "/mapChart/makeListSource"
    );
}


