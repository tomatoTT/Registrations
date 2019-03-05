function label(data) {    
    var label = [];
    label.push(data[0].make);
    for (var i=1; i<data.length; i++) {
        if (label.indexOf(data[i].make) === -1) {
            label.push(data[i].make);
        }
    }
    label.sort();
    return label;
}