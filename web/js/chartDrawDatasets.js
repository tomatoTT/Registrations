/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function chartDrawDatasets(data) {
    
    var datasetsObjTable = []; /*Table to supply main chart*/
    var labels = []; /*list of dates MonthYears, x axle for main chart*/
    var makes = []; /*list of unique makes from Registrations table*/
    
    for (i=0; i<data.length; i++) {
             
        if (!makes.find(data[i].make)) {
            makes.push(data[i].make)
        }
        
        
        
    }
    
    return datasetsObjTable;
}

