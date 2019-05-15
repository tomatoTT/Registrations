function regionLoad(url, input) {
    $.ajax({
        type: 'POST',
        url: url,
        data: input,
        dataType: 'json',
        success: function(data) {
            console.log(input);
            console.log(data);
            if (data[0].woj) {
                selectListProvince(data);
            } else if (data[0].pow) {
                selectListCounty(data);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown, textStatus, xhr);
        }
    });
}

function selectListProvince(data) {
    let i, option = '';
    for (i=0; i<data.length; i++) {
        option += '<label for="province'+data[i].woj+'"><input type="checkbox" id="province'+data[i].woj+'" />'+data[i].nazwa+'</label>'
    }
    $('#checkboxesProvince').append(option);
}

function selectListCounty(data) {
    let i, option = '';
    for (i=0; i<data.length; i++) {
        option += '<label for="county'+data[i].pow+'"><input type="checkbox" id="county'+data[i].pow+'" />'+data[i].nazwa+'</label>'
    }
    $('#checkboxesCounty').append(option);
}
