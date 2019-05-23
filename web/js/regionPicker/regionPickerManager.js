function regionLoad(url, input) {
    $.ajax({
        type: 'POST',
        url: url,
        data: input,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data[0].pow) {                
                selectListCounty(data);
            } else {
                selectListProvince(data);
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
        option += '<label for="province'+data[i].woj+'"><input type="checkbox" id="province'+data[i].woj+'" />'+data[i].nazwa+'</label>';
    }
    $('#checkboxesProvince').append(option);
}

function selectListCounty(data) {
    let i, option = '';
    for (i=0; i<data.length; i++) {
        let id = '';
        if (data[i].pow < 10) {
            id = data[i].woj.toString() + '0' + data[i].pow.toString();
        } else {
            id = data[i].woj.toString() + data[i].pow.toString();
        }
        option += '<label for="county'+id+'"><input type="checkbox" id="county'+id+'" />'+data[i].nazwa+'</label>';
    }
    $('#checkboxesCounty').children().remove();
    $('#checkboxesCounty').append(option);
}

function regionPickerManager() {
    $('#checkboxesProvince').click(function() {
        let i, inputProvince = {}, selectedProvince = [];
        $('#checkboxesProvince input:checked').each(function() {
            selectedProvince.push($(this).attr('id').substring(8, 10));
        });
        
        for (i=0; i<selectedProvince.length; i++) {
            inputProvince["province"+i] = selectedProvince[i];
        }
        regionLoad('/teryt/getCounty', inputProvince);
    });
    $('#checkboxesCounty').click(function(e) {
        let myTarget = e.target.querySelector('input'), inputData;
        if (myTarget) {
            inputData = inputDataSet();
            inputData.county = myTarget.id.substring(6, 10);
            countyClickLoad("/mapChart/loadCountyDetails", inputData);
            checkBoxLineChart("#lineChartForMap", inputData);
        }
        
    });
}