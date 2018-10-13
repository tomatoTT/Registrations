/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function chartDrawDatasets(data) {
    
    var datasetsObjTable = []; /*Table to supply main chart*/
    
    for (i=0; i<data.length; i++) {
        
        var datasetsObj = {};
            
        datasetsObj = {
            label: label(data),
            yAxisID: 'A', 
            data: dataForDatasetsObj(data[i].make, data), 
            backgroundColor: ['rgba(255, 99, 132, 0)'], 
            borderColor: ['rgba(255,99,132,1)'], 
            borderWidth: 2
        };
        
        datasetsObjTable.push(datasetsObj);
    }
        
    return datasetsObjTable;
}

function dataForDatasetsObj(make, data) {
    
    var units = [];
    
    for (j=0; j<data.length; j++) {
        
        if (make === data[j].make) {
            units.push(data[j].units);
        }

    }
    
    return units;   
}

