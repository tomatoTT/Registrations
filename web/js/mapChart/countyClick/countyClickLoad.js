function countyClickLoad(url, inputData, countyList) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
                mapChartDetailsCss(inputData.county, data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function mapChartDetails(data, county) {
    $("#mapDetails").append('<div id="detailsTableCounty"></div>');
    $("#detailsTableCounty").append('<p id="county'+county+'">'+county+'</p></br>');
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
}

function mapChartDetailsAdd(data, county) {
    $("#detailsTableCounty").append('<p id="county'+county+'">'+county+'</p>');
    var table, rows, i, j, make, makeIndex, units, tiv, newUnits, newTiv, rowsLength;
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
}

function mapChartDetailsSubtract(data, county) {
    var table, rows, i, j, make, units, tiv, newUnits, rowsLength, pList;
    $("#county"+county).remove(); //remove p county element
    pList = $("#detailsTableCounty").find("p");
    table = document.getElementById("detailsTable");
    rows = table.rows;
    rowsLength = rows.length;
    console.log(pList);
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
    var pList, countyList = [], table, i, countyx;
    pList =$("#detailsTableCounty").find("p");
    console.log(pList);
    if (pList.length === 0) {
        return;
    } else {
        table = document.getElementById("detailsTable");
        $("#detailsTable").remove();
        for (i=0; i<pList.length; i++) {        
            countyList.push(pList[i].innerText);
            countyx = "county" + i;
            inputData[countyx] = pList[i].innerText;
        }
        delete inputData.make;
        console.log(inputData);
        countyClickLoadUpdate("/mapChart/loadCountyDetailsUpdate", inputData);
        for (i=0; i<pList.length; i++) {        
            countyList.push(pList[i].innerText);
            countyx = "county" + i;
            delete inputData[countyx];
        }
    }    
}

function countyClickLoadUpdate(url, inputData) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
                mapChartDeatilsUpdate(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function mapChartDeatilsUpdate(data) {
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
}

function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("detailsTable");
    console.log(table.rows.length);
    switching = true;
    /*Make a loop that will continue until
     no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[1];
            y = rows[i + 1].getElementsByTagName("TD")[1];
            //check if the two rows should switch place:
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
                //if so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            }
        }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}