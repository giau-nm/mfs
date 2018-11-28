$(document).ready(function() {
    $(document).on('click', '#profile-chatwork-id', function(e) {
        $('#profile-modal-chatwork-id').modal('show');
    });

    $(document).on('click', '#profile-modal-change-chatworkid-btnsave', function(e) {
        var chatworkId = $('#chatwork-id').val();
        if (chatworkId === '') return false;

        $(this).callAjax({
            'data': {chatworkId: chatworkId},
            'successCallbackFunction': function(result) {
                if (result.status === 'success') {
                    location.reload(true);
                }
            }
        })
    })
});
