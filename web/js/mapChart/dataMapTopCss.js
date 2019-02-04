function dataMapTopCss(data) {
    $(".st0").css('fill', 'rgba(255,255,255,0)');
    $(".st1").css('fill', 'rgba(255,255,255,0)');
    var mapKeySource = [];
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
                    '<stop offset='
                    +gradientInputPrecentage+' style="stop-color:'
                    +obj1[key].color+';stop-opacity:1" />';
                if ($.inArray(obj1[key].make, mapKeySource) === -1) {
                    mapKeySource.push(obj1[key].make);
                    $("#inputForm").append('<button class="makeTopSelect" id="'+obj1[key].make+'" style="background-color:'+obj1[key].color+'">'+obj1[key].make+'</button>');
                }
                $("#" + county).attr("data-"+obj1[key].make, obj1[key].make);
            });
            gradientSvg = '<svg><linearGradient id="grad'+county+'">'
                    +gradientInput+'</linearGradient></svg>';
            $('body').append(gradientSvg);
            $("#" + county).css('fill', 'url(#grad'+county+')');
            
        } else {
            $("#" + county).css('fill', obj1.color);
            $("#" + county).attr("data-"+obj1.make, obj1.make);
            if ($.inArray(obj1.make, mapKeySource) === -1) {
                mapKeySource.push(obj1.make);
                $("#inputForm").append('<button class="makeTopSelect" id="'+obj1.make+'" style="background-color:'+obj1.color+'">'+obj1.make+'</button>');
            }            
        }    
    });
    
    $("#mapKeyGraph").hide();

    


    
}

function makeTopSelect() {
    $(".makeTopSelect").click(function() {
        var make = this.id;
        $('[data-'+make+'="'+make+'"]').toggle(function() {
            $('[data-'+make+'="'+make+'"]').css('fill', 'rgb(255,255,255)');          
        });
        $("#"+make).toggle(function() {
            $("#"+make).css('background-color', 'rgb(255,255,255)');
        });
    });
}
