function dataMapMS(data) {
    var ms = [];
    for (var i=0; i<data.length; i++) {
        var msSingle = [data[i].county, data[i].units/data[i].tiv, data[i].color];
        ms.push(msSingle);        
    }
    return ms;
}