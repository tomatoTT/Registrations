function dataMapTivCss(data) {
    $(".st0").css('fill', 'rgba(255,255,255,0)');
    $(".st1").css('fill', 'rgba(255,255,255,0)');
    var maxTiv = Math.max.apply(Math, data.map(function(o) { return o.tiv; }));    
    for (var i=0; i<data.length; i++) {
            $("#" + data[i].countyCode).css('fill', 'rgba(0, 0, 0, '+data[i].tiv/maxTiv+')');
    }
    mapKeyTiv ();
    mapKeyTitleTiv (maxTiv);
}

function mapKeyTiv () {
    var linearGradient = 
        '<svg>\n\
            <linearGradient id="gradMapKey" x1="0%" y1="0%" x2="0%" y2="100%">\n\
                <stop offset="0%" style="stop-color:rgb(0, 0, 0); stop-opacity:1" />\n\
                <stop offset="100%" style="stop-color:rgb(0, 0, 0); stop-opacity:0" />\n\
            </linearGradient>\n\
        </svg>';
    $('body').append(linearGradient);
    $("#mapKeyGraph").css('fill', 'url(#gradMapKey)');
}

function mapKeyTitleTiv (maxTiv) {
    $("#mapKeyTitle1").text("Rynek");
    $("#mapKeyTitleTop").text(maxTiv);
    $("#mapKeyTitleDown").text("0");
}