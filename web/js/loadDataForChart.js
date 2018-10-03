/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$.ajax({
    url: "",
    method: "POST",
    dataType: "json",
    async: true,
    success: function(data) {
        
    },
    error: function(xhr, textStatus, errorThrown) {
        alert(errorThrown);
    }
});

