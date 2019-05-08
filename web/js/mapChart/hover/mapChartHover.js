function mapChartHover()  {
    $(".st0, .st1").hover(
        function(e) {
            let county = $(this).data("county");
            $("body").append('<p id="tooltip">'+county+'</p>');            
            $('#tooltip').css({
                left:  e.pageX,
                top:   e.pageY
            }); 
        },
        function() {
            $('#tooltip').remove();
        }
            );
}