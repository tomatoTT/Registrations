function loadDataForChart(url, chartId) {
    $.ajax({
        url: url,
        method: "POST",
        dataType: "json",
        async: true,
        success: function(data) {
            
            if (data.length > 0) {

            chartDraw(chartId, labelsForMainChart(data), data);
            
            } else {
                
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}
