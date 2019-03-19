function lineChartDrawDatasets(data, labels) {   
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
    datasetsObj = {
        label: "TIV",
        yAxisID: 'B',
        data: unitsForDatasetsObjLeftAxle(data, labels),
        backgroundColor: 'rgba(0, 0, 0, 0.3)',
        borderColor: 'rgba(0, 0, 0, 0.3)',
        borderWidth: 2,
        pointRadius: 0
    };
    datasetsObjTable.push(datasetsObj);
    return datasetsObjTable;
}

function unitsForDatasetsObj(make, data, labels) {
    var units = [], i, query, result;
    for (i=0; i<labels.length; i++) {
        query = {
            regYear: parseInt(labels[i].slice(0, 4)), 
            regMonth: parseInt(labels[i].slice(5, 7)), 
            make: make
        };
        function search(data){
            return Object.keys(this).every((key) => data[key] === this[key]);
        }
        result = data.filter(search, query);
        if (result.length === 0) {
            units.push(0);            
        } else {
            var ms = result[0].units/result[0].tiv;
            units.push(ms.toFixed(2));            
        }
    }
    return units;   
}

function unitsForDatasetsObjLeftAxle(data, labels) {
    var tivTable = [], tiv, i, query, result;
    for (i=0; i<labels.length; i++) {
        query = {
            regYear: parseInt(labels[i].slice(0, 4)), 
            regMonth: parseInt(labels[i].slice(5, 7))
        };
        function search(data){
            return Object.keys(this).every((key) => data[key] === this[key]);
        }
        result = data.filter(search, query);
        if (result.length === 0) {
            tivTable.push(0);            
        } else {
            tiv = result[0].tiv;
            tivTable.push(tiv);            
        }
    }
    console.log(tivTable);
    return tivTable;
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

