function countyClickLoad(url, inputData, id) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
                mapChartDeatilsCss(id, data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function mapChartDetails(data) {
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

function mapChartDetailsAdd(data) {
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

function mapChartDetailsSubtract(data) {
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
                newUnits = units - data[j].units;                
                if (newUnits === 0) {
                    $(rows[i]).remove();
                    if (document.getElementById("detailsTable").rows.length === 1) {
                        document.getElementById("detailsTable").remove();
                    }
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

function mapChartDeatilsCss(id, data) {
    if ($("#"+id).data("click") === "on") {
        mapChartDetailsSubtract(data);
        $("#"+id).css("stroke-width", "1");
        $("#"+id).data("click", "off");
    } else {
        if (document.getElementById("detailsTable")) {
            mapChartDetailsAdd(data);
            $("#"+id).css("stroke-width", "2");
            $("#"+id).data("click", "on");
        } else {
            mapChartDetails(data);
            $("#"+id).css("stroke-width", "2");
            $("#"+id).data("click", "on");
        }

    }
    
}