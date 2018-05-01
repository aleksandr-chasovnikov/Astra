// ;(function ($) {
//
//     // Настройка для ajax-запросов методом POST
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//
//     // Валидация формы
//     if ($('js-sort-select').length) {
//         $('js-sort-select').on('change', function () {
//             ajaxSort($(this));
//         });
//
//     }
//
// })(jQuery);
//
// function ajaxSort(element) {
//     var attribute = {
//         name: element.attr('name'),
//         value: element.val(),
//         required: element.attr('required'),
//         data_name: element.attr('data-name'), // Для отображения ошибок перед кнопкой 'submit'
//         data_captcha: element.attr('data-captcha')
//     };
//
//     $.ajax({
//         url: '/post/ajax_validate',
//         type: 'post',
//         data: attribute,
//         dataType: 'json',
//         success: function (data) {
//             if ($.isEmptyObject(data.error)) {
//
//
//
//                 printMessage('&#9745; ' + data.success, 'success', data.name);
//                 $('.js-error-info-' + data.name).detach(); // удалить элемент
//
//             } else {
//                 printMessage('&#9746; ' + data.error, 'error', data.name);
//
//                 // Отображение ошибок перед кнопкой 'submit'
//                 if (!$('button[type=submit]').prev('.js-error-info-' + data.name).length) {
//                     $('button[type=submit]')
//                         .before(
//                             '<div class="js-error-info-'
//                             + data.name + '" style="color: red;">Неправильно заполнено поле: <a href="#'
//                             + data.name + '">'
//                             + data.data_name + ' (&#11014;перейти&#11014;)</a></div>'
//                         );
//                 }
//             }
//
//             printCountChars(data.value, data.data_name, data.maxlength);
//         }
//     });
// }