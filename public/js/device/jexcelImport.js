$(document).ready(function(e){
    var excelElement = $('#my');
    
    excelElement.jexcel({
        csv: csvLink,
        csvHeaders: true,
        colWidths: [ 40, 80, 80, 80, 100, 80, 100, 60, 80, 100, 80, 80, 80, 100, 150],
        tableOverflow:true,
        columns: [
            { type: 'numeric' },
            { type: 'text' },
            { type: 'text' },
            { type: 'dropdown', source:[ {'id':'0', 'name':'Break'}, {'id':'1', 'name':'Buzy'}, {'id':'2', 'name':'Avaiable'} ] },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'text' },
            { type: 'calendar', options: { format:'YYYY-MM-DD', time:0}},
            { type: 'text' , wordWrap:true},
        ]
    });

    $(document).on('click', '#btn-device-excel-save', function(e) {
        $('#div-error-display').css('display', 'none');
        $('#div-error-display-content').html('');

        var data = excelElement.jexcel('getData');
        excelElement.jexcel('updateSettings', {
            table: function (instance, cell, col, row, val, id) {
                $(cell).css('background-color', 'white');
            }
        })

        $(this).callAjax({
            data: {data: data},
            successCallbackFunction : function(result) {
                hideModalWait();
                if (result.status === 'error') {
                    $('#div-error-display').css('display', 'block');
                    var listDevices = JSON.parse(result.listDevices);
                    for (var i = 0, len = listDevices.length; i < len; i++) {
                        var device = listDevices[i];

                        if (typeof device.errors !== 'undefined') {
                            highlightCell(device, i);

                        }
                    }
                } else if (result.status === 'success') {
                    location.href = result.link;
                }
            }
        });
    })

    function highlightCell(listDevices, index) {
        var error = listDevices.errors;
        delete listDevices.errors;

        var keys = [];
        for(var k in listDevices) keys.push(k);

        var colCompare = null;
        for(var k in error){
            var currentError = error[k];
            colCompare = keys.findIndex(function(element) {
                return element === k;
            });
            excelElement.jexcel('updateSettings', {
                table: function (instance, cell, col, row, val, id) {
                    if (row == index && col == colCompare+1) {
                        $(cell).css('background-color', '#f46e42');
                        for (var i = 0, len = currentError.length; i < len; i++) {
                            $('#div-error-display-content').append('<br>' + currentError[i]);
                        }
                    }
                }
            })
        };
    }

    $(document).on('click', '#btn-device-excel-add-row', function() {
        excelElement.jexcel('insertRow');
    })

    $(document).on('click', '#btn-device-excel-delete-row', function() {
        excelElement.jexcel('deleteRow', excelElement.jexcel('getSelectedRow'));
    })
});