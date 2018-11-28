$(document).ready(function() {
    $(document).on('click', '.btn-delete', function() {
        var requestId = $(this).data('request-id');
        $('#btn-delete').attr('data-request-id', requestId);
    });

    $(document).on('click', '#btn-delete', function() {
        var requestId = $(this).data('request-id');
        $('#form-delete-' + requestId).submit();
    });
    window.setTimeout(function() {
        $('.alert-success').slideUp(500, function(){
            $(this).css('display', 'none');
        });
    }, 5000);
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction': function(result) {
                hideModalWait();
                $("#modal-ajax").modal('show');
                $('#modal-ajax').html(result);
            }
        })
    });
    var currentTr = null;
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        currentTr = $(this).parents('tr');
        $(this).callAjax({
            'successCallbackFunction': function(result) {
                hideModalWait();
                $('#modal-ajax').html(result);
                $("#modal-ajax").modal('show');

                datePicker();
            },
        })
    });
    $(document).on('submit', '#form-update', function(e) {
        e.preventDefault();
        var form = $(this);
        $('#form-update').callAjax({
            'successCallbackFunction': function(result) {
                hideModalWait();
                if (result.status == 'success') {
                    $("#modal-ajax").modal('hide');
                    updateData(currentTr, form, result.message, result.html);
                } else if (result.html || typeof result === 'string') {
                    if (result.html) $('#modal-ajax').html(result.html);
                    if (typeof result === 'string') $('#modal-ajax').html(result);
                    datePicker();
                } else {
                    $(".help-block").remove();
                    $('.form-group').removeClass('has-error');
                    $('#form-update-display-fail').find('h4').first().html('<i class="icon fa fa-ban"></i>' + result.message);
                    $('#form-update-display-fail').css('display', 'block');
                }
            },
        });
    });

    var filterByStatusElement = $('#filter-user-by-status');
    filterByStatusElement.fSelect({
        placeholder: filterByStatusElement.data('placeholder'),
        numDisplayed: 4,
        overflowText: filterByStatusElement.data('overflowText'),
        noResultsText: filterByStatusElement.data('noResultsText'),
        searchText: filterByStatusElement.data('searchText'),
        showSearch: false
    });

    $('#btn-add-request').on('click', function() {
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                $('#modal-ajax').html(result);
                $('#modal-ajax').find('input, select, textarea').val('');
                initInput();
                $('#modal-ajax').modal('show');
            }
        });
    });

    $(document).on('submit', '#form-add-request', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                if (result.status == 'success') {
                    addData(result.html, result.message);
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

    var updateStatusUrl = null;
    $(document).on('click', '.request-href-change-status', function(e) {
        e.preventDefault();

        $('#request-modal-display-fail').css('display', 'none');

        updateStatusUrl = $(this).data('url');
        var currentRequestStatus = $(this).data('status');
        var btnApprove = $('#request-btn-approve');
        var btnReject = $('#request-btn-reject');
        var btnPaid = $('#request-btn-paid');

        if (currentRequestStatus === listRequestStatus.statusNew) {
            deActiveBtn(btnReject);
            deActiveBtn(btnApprove);
            activeBtn(btnPaid);
            return true;
        }
        if (currentRequestStatus === listRequestStatus.statusAccept) {
            activeBtn(btnReject);
            activeBtn(btnApprove);
            deActiveBtn(btnPaid);
            return true;
        }
        if (currentRequestStatus === listRequestStatus.statusReject) {
            activeBtn(btnReject);
            deActiveBtn(btnApprove);
            return true;
        }
    });

    $(document).on('click', '.request-btn-change-status', function(e) {
        var status = $(this).data('status')
        $('#request-modal-change-status').callAjax({
            url: updateStatusUrl,
            data: {
                status: status,
            },
            successCallbackFunction: function(result) {
                hideModalWait();
                if (result.status === 'success') {
                    location.reload(true);
                } else {
                    var elementDisplayError = $('#request-modal-display-fail-content');
                    elementDisplayError.html('<i class="icon fa fa-ban"></i>' + result.message)
                    $('#request-modal-display-fail').css('display', 'block');
                }
            }
        })
    });
});

function activeBtn(btn) {
    btn.removeClass(btn.data('class-before'));
    btn.addClass(btn.data('class-after'))
    btn.parent().hide();
}
function deActiveBtn(btn) {
    btn.removeClass(btn.data('class-after'));
    btn.addClass(btn.data('class-before'))
    btn.parent().show();
}

function updateData(currentTr, form, message, html) {
    currentTr.find('td[data-name]').each(function() {
        var name = $(this).data('name');
        var value = form.find('[name=' + name + ']').val();
        if ($('[name='+ name + ']').is("select")) {
            value = form.find('select[name=' + name + '] option:selected').text();
        }
        if (html !== null) value = html.toHtml();
    });
    $('.alert-success').text(message);
    $('.alert-success').show();
    hideMessage();
}

function datePicker() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        daysOfWeekDisabled: [0,6],
    });
    $('#actualStartTime').on("changeDate", function(selected) {
        var newStartDate = new Date($('#actualStartTime').val());
        var endDate = "", count = 0;
        while (count < maxRequestDate) {
            endDate = new Date(newStartDate.setDate(newStartDate.getDate() + 1));
            if (endDate.getDay() != 0 && endDate.getDay() != 6) {
               count++;
            }
        }
       
        $('#actualEndTime').val(null);
        $('#actualEndTime').datepicker('setStartDate', new Date(selected.date.valueOf()));
        $('#actualEndTime').datepicker('setEndDate', endDate);
        $('#actualEndTime').datepicker('setDatesDisabled', [endDate]);
    })
}

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

function addData(html, message) {
    $('#requests-table tbody').prepend(html);
    $('.alert-success').text(message);
    $('.alert-success').show();
    $('#modal-ajax').modal('hide');
    hideMessage();
}
function hideMessage() {
    $('.alert-success[role=alert]').remove();
    window.setTimeout(function() {
        $('.alert-success').slideUp(500, function(){
            $(this).css('display', 'none');
        });
    }, 5000);
}