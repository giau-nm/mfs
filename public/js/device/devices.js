$(document).ready(function(e){
    var changeStatusUrl = '';
    $(document).on('click', '.btn-change-status', function(e) {
        e.preventDefault();
        $('#status-device').val($(this).data('status'));
        $('#modal-change-status').modal('show');
        changeStatusUrl = $(this).attr('href');
    });

    $(document).on('click', '.show_popup', function(e) {
        var device_id = $(this).parents('tr').attr('data-id');
        $('#status-device').val($(this).data('status'));
        $.ajax({
            url: $('#url_get_user_request').val(),
            type: 'POST',
            data: {device_id: device_id},
            success: function(result) {
                $('#modal-request-info').modal('hide');
                if(result.status){
                    $('#modal-request-info .modal-content').html(result.data);
                    $('#modal-request-info').modal('show');
                }
            }
        });
    });

    $(document).on('click', '#btn-confirm-change-status', function(e) {
        e.preventDefault();
        if (changeStatusUrl != '') {
            var status = $('#status-device').val();
            $.ajax({
                url: changeStatusUrl,
                type: 'POST',
                data: {status: status},
                success: function(result) {
                    $('#modal-change-status').modal('hide');
                    showNotification(result.status, result.message);
                    if (result.status == 'success') {
                        location.href = location.href;
                    }
                }
            });
        }
    });
    
    $("#btn-import-csv-devices").on("click", function(e) {
        e.preventDefault();
        $("#file-import-csv-devices").trigger("click");
    });
    $("#file-import-csv-devices").change(function(e){
        var url = $(this).data('href');
        var formData = new FormData();
        formData.append("file", $('#file-import-csv-devices')[0].files[0]);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                showLoading();
            },
            success: function(result) {
                hideLoading();
                showNotification(result.status, result.message);
                $('#file-import-csv-devices').val('');
                if (result.status == 'success') {
                    location.href = location.href;
                } else if (typeof result.link !== 'undefined') {
                    location.href = result.link;
                }
            }
        }).done(function(){
            hideLoading();
            $('#file-import-csv-devices').val('');
        }).fail(function(xhr, textStatus, errorThrown){
            var result = xhr.responseJSON;
            hideLoading();
            showNotification(result.status, result.message);
            $('#file-import-csv-devices').val('');
        });
    });

    //Build Tabulator
    if ($("#csv-table").length) {
        var checkError = function () {
            var flag = false;
            $.each($('.tabulator-cell'), function(index, element) {
                if ($(element).hasClass('tabulator-validation-fail')) {
                    flag = true;
                }
            });
            return flag;
        }

        var disabledButtonSave = function () {
            $('#set-data').attr('disabled', 'disabled');
        }
        var enabledButtonSave = function () {
            $('#set-data').removeAttr('disabled');
        }
        //Create Date Editor
        var dateEditor = function(cell, onRendered, success, cancel){
            var editor = $("<input type='date' format='YYYY-MM-DD'></input>");
            editor.css({
                "padding":"3px",
                "width":"100%",
                "box-sizing":"border-box",
            });

            //Set value of editor to the current value of the cell
            editor.val(moment(cell.getValue(), "YYYY-MM-DD").format("YYYY-MM-DD"));

            //set focus on the select box when the editor is selected (timeout allows for editor to be added to DOM)
            onRendered(function(){
                editor.focus();
                editor.css("height","100%");
            });

            //when the value has been set, trigger the cell to update
            editor.on("change blur", function(e){
                success(moment(editor.val(), "YYYY-MM-DD").format("YYYY-MM-DD"));
            });

            //return the editor element
            return editor;
        };

        var isValidDate = function(cell, value, parameters){
            if(value == '')
                return false;

            var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
            var dtArray = value.match(rxDatePattern); // is format OK?

            if (dtArray == null)
                return false;

            //Checks for mm/dd/yyyy format.
            dtMonth = dtArray[3];
            dtDay= dtArray[5];
            dtYear = dtArray[1];

            if (dtMonth < 1 || dtMonth > 12)
                return false;
            else if (dtDay < 1 || dtDay> 31)
                return false;
            else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
                return false;
            else if (dtMonth == 2)
            {
                var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
                if (dtDay> 29 || (dtDay ==29 && !isleap))
                        return false;
            }
            return true;
        }

        $("#csv-table").tabulator({
            height:"500px",
            pagination:"local",
            paginationSize:20,
            tooltips:true,
            columns:[
                {title:"Name", field:"name", width:150, editor:"input", validator:["required", "string", "minLength:1", "maxLength:55"]},
                {title:"Status", field:"status", editor:"select", editorParams:{"0":"Broken", "1":"Buzy", "2":"Avaiable"}, validator:["required", "in:0|1|2"], formatter:function(cell, formatterParams){
                    var value = cell.getValue();
                    if (value == 0) {
                        return '<span class="text-red">Broken</span>';
                    } else if (value == 1) {
                        return '<span class="text-yellow">Buzy</span>';
                    } else if (value == 2) {
                        return '<span class="text-green">Avaiable</span>';
                    }
                }},
                {title:"Code", field:"code", width:150, editor:"input", validator:["required", "minLength:1", "maxLength:45"]},
                {title:"Screen size", field:"screen_size", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"OS", field:"os", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Type", field:"type", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Manufacture", field:"manufacture", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Carrier", field:"carrier", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Note", field:"note", width:150, editor:"textarea"},
                {title:"Phone number", field:"phone_number", width:150, editor:"input", validator:["minLength:1", "maxLength:30"]},
                {title:"Imei", field:"imei", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Udid", field:"udid", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Serial", field:"serial", width:150, editor:"input", validator:["minLength:1", "maxLength:45"]},
                {title:"Checked at", field:"checked_at", width:150, editor:dateEditor, validator:[isValidDate]},
            ],
            validationFailed:function(cell, value, validators){
                $('#set-data').attr('disabled', 'disabled');
                var row = cell.getRow();
                row = row.getElement();
                if (typeof row !== 'undefined' && !$(row).hasClass('row-table-error')) {
                    $(row).addClass('row-table-error');
                }
            },
            rowFormatter:function(row, data){
                var element = row.getElement(),
                data = row.getData(),
                width = element.outerWidth(),
                table;
                errors = data.errors;
                if (typeof errors === 'object') {
                    element.addClass('row-table-error');
                    $('#set-data').attr('disabled', 'disabled');
                    $.each(errors, function(index, error){
                        element.find('div[tabulator-field=' + index + ']').addClass('tabulator-validation-fail');
                    });
                }
            },
            cellEditCancelled:function(cell){
                var row = cell.getRow();
                var elementRow = row.getElement();
                var cellChild = row.getCells();
                var checkErrorCell = false;
                $.each(cellChild, function(index, cellElement) {
                    var element = cellElement.getElement();
                    if ($(element).hasClass('tabulator-validation-fail')) {
                        checkErrorCell = true;
                    }
                });
                if (checkErrorCell && !$(elementRow).hasClass('row-table-error')) {
                    $(elementRow).addClass('row-table-error');
                    $('#set-data').attr('disabled', 'disabled');
                } else {
                    $(elementRow).removeClass('row-table-error');
                    $('#set-data').removeAttr('disabled');
                }
            },
            dataEdited:function(data){
                var flag = false;
                $.each($('.tabulator-cell'), function(index, element) {
                    if ($(element).hasClass('tabulator-validation-fail')) {
                        flag = true;
                    }
                    if (flag == true && !$(element).parents('.tabulator-row').hasClass('row-table-error')) {
                        $(element).parents('.tabulator-row').addClass('row-table-error');
                    } else if (flag == false && $(element).parents('.tabulator-row').hasClass('row-table-error')) {
                        $(element).parents('.tabulator-row').removeClass('row-table-error');
                    }
                });
                if (!flag) {
                    $('#set-data').removeAttr('disabled');
                } else {
                    $('#set-data').attr('disabled', 'disabled');
                }
            },
        });

        $("#csv-table").tabulator("setData", '/devices/get-data-csv?file=' + $('#csv-table').data('file-csv') );

        $('#set-data').click(function(e){
            e.preventDefault();
            if (!checkError()) {
                disabledButtonSave();
                var data = $("#csv-table").tabulator("getData");
                var url = $(this).data('href');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {data: JSON.stringify(data), 'file_csv': $('#csv-table').data('file-csv') },
                    success: function(result) {
                        showNotification(result.status, result.message);
                        if (result.status == 'success') {
                            $('#set-data').removeAttr('disabled');
                            location.href = result.link;
                        } else {
                            $("#csv-table").tabulator("setData", $.parseJSON(result.listDevices));
                        }
                    }
                });
            } else {
                disabledButtonSave();
            }
        });
    }

    $('.btn-add-request').on('click', function() {
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                $('#modal-ajax').html(result);
                $('#modal-ajax').modal('show');
                initInput();
            }
        });
    });

    $(document).on('submit', '#form-add-request', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                if (result.status == 'success') {
                    $('.alert-success').text(result.message);
                    $('.alert-success').show();
                    $('#modal-ajax').modal('hide');
                    hideMessage();
                } else if (result.html) {
                    $('#modal-ajax').html(result.html);
                    $('#modal-ajax').modal('show');
                    initInput();
                } else {
                    $('#btn-add').hide();
                    $('#modal-ajax').find('.modal-body').html('<label class="text-red">' + result.message + '</label>');
                    $('#modal-ajax').modal('show');
                }
            }
        });
    });
});

function initInput() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        daysOfWeekDisabled: [0,6],
    });
    $('#startTime').on("changeDate", function(selected) {
        var startDate = new Date($('#startTime').val());
        var endDate = "", count = 0;
        while (count < maxRequestDate) {
            endDate = new Date(startDate.setDate(startDate.getDate() + 1));
            if (endDate.getDay() != 0 && endDate.getDay() != 6) {
               count++;
            }
        }
        $('#endTime').val(null);
        $('#endTime').datepicker('setStartDate', new Date(selected.date.valueOf()));
        $('#endTime').datepicker('setEndDate', endDate);
        $('#endTime').datepicker('setDatesDisabled', [endDate]);
    });
    $('.select2').select2({
        placeholder: $(this).attr('data-placeholder')
    });
}
function hideMessage() {
    window.setTimeout(function() {
        $('.alert-success').slideUp(500, function(){
            $(this).css('display', 'none');
        });
    }, 5000);
}