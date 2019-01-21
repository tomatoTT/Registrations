function dataMapCss(ms) {
    for (var i=0; i<ms.length; i++) {
        $("#" + ms[i][0]).css('fill', ms[i][2].substr(0, ms[i][2].length - 2) + ms[i][1] + ")");
    }    
}


