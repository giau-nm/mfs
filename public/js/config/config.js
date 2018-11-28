
$(document).ready(function() {
    $('#user-permission').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length >= 1;
        },
        afterMoveToRight: function(_left, _right, option) {
            var listId = [];
            option.each(function() {
                listId.push($(this).val());
            });
            updateUserPermission(listId, null);
        },
        afterMoveToLeft: function(_left, _right, option) {
            var listId = [];
            option.each(function() {
                listId.push($(this).val());
            });
            updateUserPermission(null, listId);
        },
    });

    function updateUserPermission(listUserBecomeAdmin, listUserBecomeNormal) {
        $('#user-permission').callAjax({
            'data': {
                'listBecomeAdmin': listUserBecomeAdmin,
                'listBecomeNormal': listUserBecomeNormal,
            },
        });
    }
});
