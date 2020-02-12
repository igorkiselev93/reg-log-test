/* Article FructCode.com */
$( document ).ready(function() {
    // при нажатии на кнопку вызываем sendAjaxForm
    $(".btn-registr").click(
        function(){
            sendAjaxForm('ajax_form', 'registr_handler_ajax.php');
            return false;
        }
    );
    $(".btn-login").click(
        function(){

            sendAjaxForm('ajax_form', 'login_handler_ajax.php');
            return false;
        }
    );
});

function sendAjaxForm(ajax_form, url) {

    $.ajax({
        url:     url, //url страницы
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сериализуем объект
        success: function(response) { //Данные отправлены успешно

            var result = $.parseJSON(response);
            if (result.message == "1" ){
                // если залогинились, то перезагружаем страничку
                window.location = "login.php";
            }
            else {
                // выводим ответное сообщение от сервера
                $('#result_form').html(result.message);
            }

        },
        error: function() { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены на сервер.');
        }
    });
}


