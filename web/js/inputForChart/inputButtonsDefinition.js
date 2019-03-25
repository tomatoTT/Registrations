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
                "Customize"
            ];
            break;
        case "Map TIV":
            input = [
                "YTD",
                "Rolling12",
                "QTD",
                "Rolling3",
                "Customize"
            ];
            break;
    }
    createInputMapChart(
        input, 
        "#inputForm", 
        "#slider-range", 
        "/mapChart/slideRangeSource", 
        "/mapChart/makeListSource"
    );
}


