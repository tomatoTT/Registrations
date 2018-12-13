function dataMapTopCss(data) {    
    Object.keys(data).forEach(function(key) {
        var obj1 = data[key];
        var county = key;
        var gradientSvg = "";
        if (data[key].a) {
            var gradientInput = "";
            var gradientInputPrecentage = 0;            
            Object.keys(obj1).forEach(function(key) {
                gradientInputPrecentage = 1/(Object.keys(obj1).length);
                gradientInput += 
                    '<stop offset='+gradientInputPrecentage+' style="stop-color:'+obj1[key].color+';stop-opacity:1" />';
            });
            gradientSvg = '<svg><linearGradient id="grad'+county+'">'+gradientInput+'</linearGradient></svg>';
            $('body').append(gradientSvg);
            $("#" + county).css('fill', 'url(#grad'+county+')');
        } else {
            $("#" + county).css('fill', obj1.color);
        }        
    });
}


