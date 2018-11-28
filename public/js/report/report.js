$(document).ready(function() {
    $("#report_search_status").change(function() {
        window.open($(this).attr('data-url') + '?status=' + $(this).val(), "_self")
    });

    $("#report_search-btn").click(function () {
        window.open($("#report_search-input").attr('data-url') + '?find=' + $("#report_search-input").val(), "_self")
    })
});