function chartDrawDatasets(data, labels) {
    
    var datasetsObjTable = []; /*Table to supply main chart*/
    var makes = labelMakeConditions(data, 10);

    for (var i=0; i<makes.length; i++) {

        var datasetsObj = {};
        var make = makes[i];
        datasetsObj = {
            label: make,
            yAxisID: 'A', 
            data: unitsForDatasetsObj(make, data, labels), 
            backgroundColor: 'rgba(0, 0, 0, 0)', 
            borderColor: colorForDatasetsObj(make, data), 
            borderWidth: 2,
            pointRadius: 0
        };
        
        datasetsObjTable.push(datasetsObj);

    }
    return datasetsObjTable;
}

function unitsForDatasetsObj(make, data, labels) {
    
    var units = [];
    
    for (var i=0; i<labels.length; i++) {

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

    for (var i=0; i<data.length; i++) {
        
        if (make === data[i].make) {
            color = data[i].color;
            return color;
        }
    }
}

