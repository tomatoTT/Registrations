/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function loadDataMap(url, a, b) {
    $.ajax({
        type: 'POST',
        url: url,
        data:{user_id:a,
            kupa:b
        },
        dataType: "json",
        success: function(data) {
            console.log(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

