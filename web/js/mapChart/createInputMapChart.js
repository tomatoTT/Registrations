function createInputMapChart(input=Array) {
    /*Generate input buttons*/
    if (Array.isArray(input)) {
        for (var i=0; i<input.length; i++) {
            $("#inputForm").append('<button id="'+input[i]+'" class="inputButton">'+input[i]+'</button></br>');
        }
        
    }
}


