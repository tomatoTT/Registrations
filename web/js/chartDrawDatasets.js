/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function chartDrawDatasets(data, labels) {
    
    var datasetsObjTable = []; /*Table to supply main chart*/
    var makes = label(data);

    for (i=0; i<makes.length; i++) {

        var datasetsObj = {};
        var make = makes[i];
        datasetsObj = {
            label: make,
            yAxisID: 'A', 
            data: unitsForDatasetsObj(make, data, labels), 
            backgroundColor: 'rgba(255, 99, 132, 0)', 
            borderColor: colorForDatasetsObj(make, data), 
            borderWidth: 2
        };
        
        datasetsObjTable.push(datasetsObj);

    }

    return datasetsObjTable;
}

function unitsForDatasetsObj(make, data, labels) {
    
    var units = [];
    
    for (i=0; i<labels.length; i++) {

        var query = {
            regYear: parseInt(labels[i].slice(0, 4)), 
            regMonth: parseInt(labels[i].slice(5, 7)), 
            make: make
        };

        function search(data){
            return Object.keys(this).every((key) => data[key] === this[key]);
        }
        var result = data.filter(search, query);
        
        if (result.length == 0) {
            units.push(0);
            
        } else {
            units.push(result[0].units);
            
        }        
    }

    return units;   
}

function colorForDatasetsObj(make, data) {
    
    var color = '';
    
    for (i=0; i<data.length; i++) {
        
        if (make === data[i].make) {
            color = data[i].color;

            return color;
        }
    }
}

