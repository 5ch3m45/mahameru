$(function() {
    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''));
    })

    $('#current-page').on('keyup paste', debounce(function(){
        $('#page-input').val($('#current-page').val());
        $('#filter-form').submit();
    }, 300));
});