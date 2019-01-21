function dataMapMSCss(ms) {
    $(".st0").css('fill', 'rgba(255,255,255,0)');
    $(".st1").css('fill', 'rgba(255,255,255,0)');
    for (var i=0; i<ms.length; i++) {
        $("#" + ms[i][0]).css('fill', ms[i][2].substr(0, ms[i][2].length - 2) + ms[i][1] + ")");
    }    
}

function mapKey(ms) {
    for (var i=0; i<10; i++) {
        $("#mapKey").append('<div id="mapKey'+i+'" class="mapKey"></div>');
    }
}

