function countyClickLoad(url, inputData) {
    $.ajax({
        type: 'POST',
        url: url,
        data: inputData,
        dataType: "json",
        success: function(data) {
            if (document.getElementById("detailsTable")) {
                mapChartDetailsUpdate(data);
            } else {
                mapChartDetails(data);
            }
            

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

function mapChartDetailsUpdate(data) {
    var table, rows, i, make, makeIndex, units, tiv, newUnits, newTiv;
    table = document.getElementById("detailsTable");
    rows = table.rows;

    for (i=1; i<(rows.length); i++) {
        make = rows[i].getElementsByTagName("TD")[0].innerText;
        makeIndex = data.findIndex(x => x.make === make);
        
        if (makeIndex > -1) {
            console.log(make);
            
            units = parseInt(rows[i].getElementsByTagName("TD")[1].innerText);
            tiv = parseInt(rows[i].getElementsByTagName("TD")[2].innerText);
            newUnits = units + data[makeIndex].units;
            newTiv = tiv + data[makeIndex].tiv;
            rows[i].getElementsByTagName("TD")[1].innerText = newUnits;
            rows[i].getElementsByTagName("TD")[2].innerText = newTiv;
            console.log(tiv);
            console.log(data[makeIndex].tiv);
        }
    }
}