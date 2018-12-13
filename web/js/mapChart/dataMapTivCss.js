function dataMapTivCss(data) {    
    var maxTiv = Math.max.apply(Math, data.map(function(o) { return o.tiv; }));    
    for (var i=0; i<data.length; i++) {
        $("#" + data[i].county).css('fill', 'rgba(0, 0, 0, '+data[i].tiv/maxTiv+')');
    }
}


