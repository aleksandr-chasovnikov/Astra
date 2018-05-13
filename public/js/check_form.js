;(function ($) {

    // Настройка для ajax-запросов методом POST
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Добавляет атритут required и подпись "обязательно"
    $('.required')
        .attr('required', 'required')
        /*.attr('placeholder', 'Обязательное поле')*/;

    // Валидация формы
    if ($('.ajax-validate').length) {
        $('.ajax-validate').on('input', function () {
            ajaxValidateForm($(this));
        });

        // всплывашка при попытке закрыть или перезгрузить окно
        window.onbeforeunload = function (evt) {
            $('button[type=submit]').click( function() {
                $(this).data('clicked', true);
            });

            if ($('button[type=submit]').data('clicked')) {
                return null;
            }
            return true;
        };
    }

    // Добавление фотографий
    if ($('.js-addPhoto').length) {
        $('.js-addPhoto').click(function () {
            if ($('.js-inputPhoto').length < $('.js-addPhoto').attr('data-count')) {
                $('.js-addPhoto').before(
                    '<input name="files[]" type="file" class="form-control js-inputPhoto" '
                    + ' value="" multiple><br>'
                );
            }
        });
    }

    // Обновить картинку капчи
    if ($('.js-captchaRefresh').length) {
        $('.js-captchaRefresh').click(function () {
            $.ajax({
                url: '/ajax_captcha_refresh',
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $('#captchaImage').detach();
                    $('.js-captchaRefresh').before(
                        '<img id="captchaImage" src="/images/captcha/'
                            + data.captcha + '.jpg" alt="">'
                    );
                }
            });
        });
    }

})(jQuery);


// Отображение сообщения после инпутов
function printMessage(msg, className, dataName) {
    $('[name=' + dataName + ']').next('.print-error-msg')
        .removeClass()
        .addClass('print-error-msg ' + className)
        .html(msg);
}

// Отображение кол-ва символов в инпуте
function printCountChars(dataValue, dataName, maxLength) {
    $('[data-name=' + dataName + ']').prev('span')
        .removeClass()
        .addClass('print-count-chars ')
        .html('&nbsp; [' + (dataValue.length) + ' из ' + maxLength + ']');
}

// Валидация через PostController::ajaxValidate()
function ajaxValidateForm(element) {
    var attribute = {
        name: element.attr('name'),
        value: element.val(),
        required: element.attr('required'),
        data_name: element.attr('data-name'), // Для отображения ошибок перед кнопкой 'submit'
        // data_captcha: element.attr('data-captcha')
    };

    $.ajax({
        url: '/post/ajax_validate',
        type: 'post',
        data: attribute,
        dataType: 'json',
        success: function (data) {
            if ($.isEmptyObject(data.error)) {
                printMessage('&#9745; ' + data.success, 'success', data.name);
                $('.js-error-info-' + data.name).detach(); // удалить элемент

            } else {
                printMessage('&#9746; ' + data.error, 'error', data.name);

                // Отображение ошибок перед кнопкой 'submit'
                if (!$('button[type=submit]').prev('.js-error-info-' + data.name).length) {
                    $('button[type=submit]')
                        .before(
                            '<div class="js-error-info-'
                            + data.name + '" style="color: red;">Неправильно заполнено поле: <a href="#'
                            + data.name + '">'
                            + data.data_name + ' (&#11014;перейти&#11014;)</a></div>'
                        );
                }
            }

            // Отображение кол-ва симвовлов в поле
            // printCountChars(data.value, data.data_name, data.maxlength);
        }
    });
}

function in_array(needle, haystack, strict1) {   // Checks if a value exists in an array
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    var found = false,
        key,
        strict = !!strict1;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }
    return found;
}
