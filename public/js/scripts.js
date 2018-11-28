function showNotification(type, message) {
    if (type == 'success') {
        $('.alert-success').hide();
        $('.alert-danger').hide();
        $('.alert-success.js').html(message).show();
        setTimeout(function(){
            $('.alert-success').html('').slideUp(300);
        }, 3000);
    } else {
        $('.alert-danger').hide();
        $('.alert-success').hide();
        $('.alert-danger.js').html(message).show();
        setTimeout(function(){
            $('.alert-danger').html('').slideUp(300);
        }, 3000);
    }
}
function showLoading(){
    $('#loading').show();
}
function hideLoading(){
    $('#loading').hide();
}
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.table-sorter thead th a.sort').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        window.location.href = url;
    });

    var deleteUrl = '';
    var dataDelete = {};
    var dataRow = null;
    $(document).on('click', '.btn-delete-item', function(e) {
        e.preventDefault();
        $('#modal-delete').modal('show');
        deleteUrl = $(this).attr('href');
        dataDelete = $(this).data();
        dataRow = $(this).parents('tr');
    });
    $(document).on('click', '#btn-confirm-delete', function(e) {
        e.preventDefault();
        if (deleteUrl != '') {
            $(this).callAjax({
                url: deleteUrl,
                successCallbackFunction : function(result) {
                    hideModalWait();
                    $('#modal-delete').modal('hide');
                    showNotification(result.status, result.message);
                    if (result.status == 'success') {
                        dataRow.remove();
                    }
                }
            });
        }
    });

    $('#user-info-panel').click(function(){
        location.href = $(this).data('href');
    });

    $('.device-name').click(function(){
        $.post($('#url_ajax_device_detail').val(), {device_id: $(this).attr('data-deviceid')}, function(result){
            if(result.status){
                $('#modal-device-info').modal('hide');
                if(result.status){
                    $('#modal-device-info .modal-content').html(result.data);
                    $('#modal-device-info').modal('show');
                }
            }
        })
    });
});
