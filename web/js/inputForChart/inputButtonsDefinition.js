function inputButtonsDefinition(siteTitle) {
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
    }
    createInputMapChart(
        input, 
        "#inputForm", 
        "#slider-range", 
        "/mapChart/slideRangeSource", 
        "/mapChart/makeListSource"
    );
}


