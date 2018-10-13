/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function chartDrawDatasets(data) {
    
    var datasetsObjTable = []; /*Table to supply main chart*/
    var makes = label(data);

    for (i=0; i<makes.length; i++) {
        
        var datasetsObj = {};
    
        datasetsObj = {
            label: makes[i],
            yAxisID: 'A', 
            data: unitsForDatasetsObj(makes[i], data), 
            backgroundColor: ['rgba(255, 99, 132, 0)'], 
            borderColor: [colorForDatasetsObj(makes[i], data)], 
            borderWidth: 2
        };
        
        datasetsObjTable.push(datasetsObj);
    }
    return datasetsObjTable;
}

function unitsForDatasetsObj(make, data) {
    
    var units = [];
    
    for (j=0; j<data.length; j++) {
        
        if (make === data[j].make) {
            units.push(data[j].units);
        }

    }
    
    return units;   
}

function colorForDatasetsObj(make, data) {
    
    var color = '';

    for (k=0; k<data.length; k++) {
        if (make === data[k].make) {
            color = data[k].color;

            return color;
        }
    }
}

