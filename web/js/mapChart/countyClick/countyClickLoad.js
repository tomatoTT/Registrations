function countyClickLoad(url, inputData) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        async: false,
        success: function(data) {
            console.log(data);
                mapChartDetailsCss(inputData.county, data);
        },
        beforeSend: function() {
            $("h1").show();
        },
        complete: function() {
            $("h1").hide();
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function mapChartDetails(data, county) {
    $("#mapDetails").append('<div id="detailsTableCounty"></div>');
    $("#detailsTableCounty").append('<p id="county'+county+'">'+county+'</p>');
    $("#mapDetails").append('<table id="detailsTable"></table>');
    $("#detailsTable").append(
            '<tr>\n\
                <th>Make</th>\n\
                <th>Units</th>\n\
                <th>TIV</th>\n\
                <th>MS</th>\n\
            </tr>'
            );
    for (var i=0; i<data.length; i++) {
        $("#detailsTable").append('\
                <tr>\n\
                    <td>'+data[i].make+'</td>\n\
                    <td>'+data[i].units+'</td>\n\
                    <td>'+data[i].tiv+'</td>\n\
                    <td>'+((data[i].units/data[i].tiv*100).toFixed(2))+'%</td>\n\
                </tr>'                
                );
    }
    sortTable("detailsTable", 1);
}

function mapChartDetailsAdd(data, county) {
    $("#detailsTableCounty").append('<p id="county'+county+'">'+county+'</p>');
    var table, rows, i, j, make, units, tiv, newUnits, rowsLength;
    table = document.getElementById("detailsTable");
    rows = table.rows;
    rowsLength = rows.length;
    loop:
    for (j=0; j<data.length; j++) {        
        for (i=1; i<rowsLength; i++) {
            make = rows[i].getElementsByTagName("TD")[0].innerText;            
            if (make === data[j].make) {
                units = parseInt(rows[i].getElementsByTagName("TD")[1].innerText);
                newUnits = units + data[j].units;
                rows[i].getElementsByTagName("TD")[1].innerText = newUnits;
                continue loop;
            }            
        }
        $("#detailsTable").append('\
            <tr>\n\
            <td>'+data[j].make+'</td>\n\
            <td>'+data[j].units+'</td>\n\
            <td></td>\n\
            <td></td>\n\
            </tr>'
        );
    }
    tiv = 0;
    for (i=1; i<rows.length; i++) {    
        tiv += parseInt(rows[i].getElementsByTagName("TD")[1].innerText);
    }
    for (i=1; i<rows.length; i++) {
        units = rows[i].getElementsByTagName("TD")[1].innerText;
        rows[i].getElementsByTagName("TD")[2].innerText = tiv;
        rows[i].getElementsByTagName("TD")[3].innerText = (units/tiv*100).toFixed(2)+'%';
    }
    sortTable("detailsTable", 1);
}

function mapChartDetailsSubtract(data, county) {
    var table, rows, i, j, make, units, tiv, newUnits, rowsLength, pList;
    $("#county"+county).remove(); //remove p county element
    pList = $("#detailsTableCounty").find("p");
    table = document.getElementById("detailsTable");
    rows = table.rows;
    rowsLength = rows.length;
    if (pList.length === 0) {
        $("#detailsTableCounty").remove();
        $("#detailsTable").remove();
        return;
    } 
    if (data.length === 0) {
        return;
    }    
    loop:
    for (j=0; j<data.length; j++) {
        for (i=1; i<rowsLength; i++) {
            make = rows[i].getElementsByTagName("TD")[0].innerText;            
            if (make === data[j].make) {
                units = parseInt(rows[i].getElementsByTagName("TD")[1].innerText);
                newUnits = units - data[j].units;                
                if (newUnits === 0) {
                    $(rows[i]).remove();
                    continue loop;
                } else {
                    rows[i].getElementsByTagName("TD")[1].innerText = newUnits;
                    continue loop;
                }                
            }            
        }
    }
    tiv = 0;
    for (i=1; i<rows.length; i++) {    
        tiv += parseInt(rows[i].getElementsByTagName("TD")[1].innerText);
    }
    for (i=1; i<rows.length; i++) {
        units = rows[i].getElementsByTagName("TD")[1].innerText;
        rows[i].getElementsByTagName("TD")[2].innerText = tiv;
        rows[i].getElementsByTagName("TD")[3].innerText = (units/tiv*100).toFixed(2)+'%';
    }
    sortTable("detailsTable", 1);
}

function mapChartDetailsCss(county, data) {
        if ($("#"+county).data("click") === "on") {
            mapChartDetailsSubtract(data, county);
            $("#"+county).css("stroke-width", "1");
            $("#"+county).data("click", "off");
        } else {
            if (document.getElementById("detailsTable")) {
                mapChartDetailsAdd(data, county);
                $("#"+county).css("stroke-width", "3");
                $("#"+county).data("click", "on");
            } else {
                mapChartDetails(data, county);
                $("#"+county).css("stroke-width", "3");
                $("#"+county).data("click", "on");
            }
        }
        return true;    
}


function mapChartDetailsCssUpdate(inputData) {
    var pList, i;
    pList =$("#detailsTableCounty").find("p");
    if (pList.length === 0) {
        return;
    } else {
        $("#detailsTableCounty").remove();
        $("#detailsTable").remove();
        $(".st0, .st1").css("stroke-width", "1");
        $(".st0, .st1").data("click", "off");
        for (i=0; i<pList.length; i++) {        
            inputData.county = pList[i].innerText;
            countyClickLoad("/mapChart/loadCountyDetails", inputData);
        }
    }    
}

function lineChartInputForMap(inputData) {
    var pList, countyx, i, temp, lineChartContainer;
    pList =$("#detailsTableCounty").find("p");
    console.log(pList);
    lineChartContainer = $("#lineChart").length;
    if (pList.length === 0) {
        $("#lineChartContainer")
            .append('<div id = "lineChart" class="chart-container"><canvas id="myChart"></canvas></div>');
        return inputData;
    } else {
        temp = {
            "regYearMin": inputData.regYearMin,
            "regMonthMin": inputData.regMonthMin,
            "regYearMax": inputData.regYearMax,            
            "regMonthMax": inputData.regMonthMax,
            "make": inputData.make,
            "county": inputData.county
        };
        if (!lineChartContainer) {
            $("#lineChartContainer")
                .append('<div id = "lineChart" class="chart-container"><canvas id="myChart"></canvas></div>');
        }
        for (i=0; i<pList.length; i++) {                
            countyx = "county" + i;
            temp[countyx] = pList[i].innerText;
        }            
        inputData = temp;
        return inputData;        
    }
}

function checkBoxLineChart(checkBoxSelecor, inputData) {
    var checked;
    checked = $(checkBoxSelecor).prop("checked");
    if (checked) {
        inputData = lineChartInputForMap(inputData);
        loadDataForLineChart("/lineChart/loadData", "myChart", inputData);
    } else {
        $("#lineChart").remove();
    }
}