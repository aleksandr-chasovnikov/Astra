;(function ($) {
    // Добавляет атритут required и подпись "обязательно"
    $('.required')
        .attr('required', 'required')
        .before('<span style="color: #aa4a24;"> (обязательно)</span>');

    // Настройка для ajax-запросов методом POST
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Валидация
    $('.ajax-validate').change(function () {
        var attribute = {
            name: $(this).attr('name'),
            value: $(this).val(),
            required: $(this).attr('required'),
            data_name: $(this).attr('data-name') // Для отображения ошибок перед кнопкой 'submit'
        };

        $.ajax({
            url: '/post/ajax_validate',
            type: 'post',
            data: attribute,
            dataType: 'json',
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    printMessage('&#9745; ' + data.success, 'success', data.name);

                    $('button[type=submit]').removeAttr('disabled');
                    $('.js-error-info-' + data.name).detach(); // удалить элемент

                } else {
                    printMessage('&#9746; ' + data.error, 'error', data.name);

                    $('button[type=submit]')
                        .before(
                            '<div class="js-error-info-'
                            + data.name + '" style="color: red;">Неправильно заполнено поле: <a href="#'
                            + data.name + '">'
                            + data.data_name + '</a></div>'
                        )
                        .attr('disabled', 'disable');
                }
            }
        });
    });

})(jQuery);


function printMessage(msg, className, dataName) {
    $('[name=' + dataName + ']').next('.print-error-msg')
        .removeClass()
        .addClass('print-error-msg ' + className)
        .html(msg);
}