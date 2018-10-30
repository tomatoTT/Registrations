/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function labelMakeConditions(data, condition) {
    
    var labelsMake = [];

    labelsMake[0] = [data[0].make, data[0].units];


    
    
    for (var i=1; i<data.length; i++) {
        var dataTab = [data[i].make, data[i].units];

        function labelTest(object) {
            return object[0] === dataTab[0];
        }
        var index = labelsMake.findIndex(labelTest);

        if (index === -1) {


            labelsMake.push(dataTab);

        } else {
            var actualUnits = labelsMake[index][1];
            labelsMake[index][1] = actualUnits + data[i].units;
        }
    }
    /*for (var i=1; i<data.length; i++) {
        var dataTab = [];
        dataTab = [data[i].make, data[i].units];
        console.log(dataTab);
        function labelTest(object) {
            return object === dataTab;
        }
        console.log(labels.find(labelTest));
        if (!labels.find(labelTest)) {

            labels.push(dataTab);
            console.log(labels);
        } else {
            var unitsAfter = labels[labels.indexOf(data[i].make)][1] + data[i].units;
            labels[labels.indexOf(data[i].make)][1] = unitsAfter;
        }
    }*/
    labelsMake.sort(function(a, b) {return b[1] - a[1];});
    var labelShort = labelsMake.slice(0, condition);
    console.log(labelShort);
    var labels = [];
    for (var i=0; i<labelShort.length; i++) {
        labels.push(labelShort[i][0]);
    }
    labels.sort();
    console.log(labels);
    return labels;

}


