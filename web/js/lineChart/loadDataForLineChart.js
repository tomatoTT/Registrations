function loadDataForLineChart(url, chartId, inputData) {
    $.ajax({
        url: url,
        method: "POST",
        data: inputData,
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                lineChartDraw(chartId, labelsForLineChart(inputData), data);            
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        },
        beforeSend: function() {
            $("#loadingImage").show();
        },
        complete: function() {
            $("#loadingImage").hide();
        }
    });
}