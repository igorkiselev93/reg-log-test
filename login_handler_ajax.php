<?php
require('functions.php');
$error = false;
// Результирующее сообщение для показа пользователю
$result = array(
    "message" => "Произошла ошибка. Вы не смогли войти",
);
$userData = array(
    "username" => htmlEntities($_POST["username"], ENT_QUOTES),
    "password" => htmlEntities($_POST["password"], ENT_QUOTES)
);
$users = dbConnect();
if (checkUsernameAndPassword($userData)){
    $result = array(
        "message" => "Вы успешно вошли. Hello ".$userData["username"],
    );
    } else {
    $result = array(
        "message" => "Вы ввели неверный username или пароль. Попробуйте еще раз",
    );
}
// Переводим массив с сообщением о результате в JSON
echo json_encode($result);
?>