function loadDataForChart(url, chartId, inputData) {
    $.ajax({
        url: url,
        method: "POST",
        data: inputData,
        dataType: "json",
        success: function(data) {
            console.log(data);
            console.log(inputData);
            if (data.length > 0) {
                chartDraw(chartId, labelsForMainChart(data), data);            
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}
