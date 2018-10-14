/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function label(data) {
    
    var label = [];
    label.push(data[0].make);

    for (i=1; i<data.length; i++) {

        if (label.indexOf(data[i].make) === -1) {
            label.push(data[i].make);
        }
    }
    return label;

}


