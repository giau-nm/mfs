$(document).ready(function() {
    $(document).on('click', '#btn-add-project', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                $('#modal-ajax').html(result);
                $('#modal-ajax').modal('show');
                $("#manager").select2();
            }
        });
    });

    $(document).on('click', '.item-edit-project', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                if(result.status == 'error') {
                    $('.alert-success').hide();
                    $('.alert-danger').html(result.message).show();
                    setTimeout(function(){
                        $('.alert-danger').html('').slideUp(300);
                    }, 3000);
                } else {
                    $('#modal-ajax').html(result);
                    $('#modal-ajax').modal('show');
                    $("#manager").select2();
                }
            }
        });
    });

    $(document).on('submit', '#form-add-project, #form-update-project', function(e) {
        e.preventDefault();
        $(this).callAjax({
            'successCallbackFunction' : function(result) {
                hideModalWait();
                if (result.status == 'success') {
                    if (typeof result.id !== 'undefined' && result.id != '') {
                        updateDataTable(result.html, result.message, result.id);
                    } else {
                        updateDataTable(result.html, result.message);
                    }
                } else if (result.html) {
                    $('#modal-ajax').html(result.html);
                    $('#modal-ajax').modal('show');
                } else {
                    $('#modal-ajax').find('.modal-body').html('<label class="text-red">' + result.message + '</label>');
                    $('#modal-ajax').modal('show');
                }
            }
        });
    });

    function updateDataTable(html, message, id) {

        if(typeof id === 'undefined' || id == '') {
            $('table#projects-table > tbody tr').removeClass('added');
            $('table#projects-table > tbody > tr:first').before(html);
        } else {
        console.log(id);
            $('table#projects-table > tbody tr').removeClass('added');
            $('table#projects-table > tbody tr[data-id="' + id + '"]').remove();
            $('table#projects-table > tbody > tr:first').before(html);
        }
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
});
