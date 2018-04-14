;(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.ajax-validate').change(function () {
        var attribute = {};

        attribute.title = $(this).val();
        // attribute.value = $(this).val();

        $.ajax({
            url: '/post/ajax_validate',
            type: 'post',
            data: attribute,
            dataType: 'json',
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    printMessage('&#9745; ' + data.success, 'success');
                } else {
                    printMessage('&#9746; ' + data.error, 'error');
                }
            }
        });
    });

}) (jQuery);


function printMessage (msg, className) {
    $('.ajax-validate').next('.print-error-msg')
        .removeClass()
        .addClass('print-error-msg ' + className)
        .html(msg);
}