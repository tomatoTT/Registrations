function dataMapMSCss(ms) {
    $(".st0").css('fill', 'rgba(255,255,255,0)');
    $(".st1").css('fill', 'rgba(255,255,255,0)');
    for (var i=0; i<ms.length; i++) {
        $("#" + ms[i][0]).css('fill', ms[i][2].substr(0, ms[i][2].length - 2) + ms[i][1] + ")");
    }    
}

function mapKeyMS(ms) {
    var color = ms[0][2].substr(4, ms[0][2].length-8);
    if ($("#gradMapKey").length) {
        $("#gradMapKey").remove(); 
        var linearGradient = 
        '<svg>\n\
            <linearGradient id="gradMapKey" x1="0%" y1="0%" x2="0%" y2="100%">\n\
                <stop offset="0%" style="stop-color:rgb'+color+'); stop-opacity:1" />\n\
                <stop offset="100%" style="stop-color:rgb'+color+'); stop-opacity:0" />\n\
            </linearGradient>\n\
        </svg>';
        $('body').append(linearGradient);
    } else {
        var linearGradient = 
        '<svg>\n\
            <linearGradient id="gradMapKey" x1="0%" y1="0%" x2="0%" y2="100%">\n\
                <stop offset="0%" style="stop-color:rgb'+color+'); stop-opacity:1" />\n\
                <stop offset="100%" style="stop-color:rgb'+color+'); stop-opacity:0" />\n\
            </linearGradient>\n\
        </svg>';
        $('body').append(linearGradient); 
    }    
    $("#mapKeyGraph").css('fill', 'url(#gradMapKey)');
}

function mapKeyTitleMS(data) {
    var make = data[0].make;
    $("#mapKeyTitleMake").text(make);
}

