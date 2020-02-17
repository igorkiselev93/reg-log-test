<?php
// подключим вспомогательные функции
require('functions.php');
// Обязательные поля ввода
$required = array('username', 'password', 'confirmpassword', 'email', 'firstname');
// Флаг для проверки ошибок
$error = false;
// Результирующее сообщение для показа пользователю
$result = array(
    "message" => "Произошла ошибка"
);
// В цикле проверяем все поля ввода - чтобы не было пустых
foreach($required as $field) {
    if (empty($_POST[$field])) {
        $error = true;
        $result = array(
            "message" => "Внимание, вы не заполнили все поля регистрации, поэтому вы не зарегистрированы"
        );
    }
};
// Проверяем совпадают ли пароли, в случае если пользователь заполнил все поля
if (!$error) {
    if ($_POST["password"]!=$_POST["confirmpassword"]){
        $error = true;
        $result = array(
            "message" => "Внимание, вы указали разные пароли"
        );
    };
}
// проверяем email
if (!$error) {
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $result = array(
            "message" => "E-mail адрес указан неверно"
        );
    }
}
// Если не было никаких ошибок, то переходим к работе с базой данных
if (!$error) {
    // создаем массив userData и обезвреживаем пользовательский ввод
    $userData = array(
        "username" => htmlEntities($_POST["username"], ENT_QUOTES),
        "password" => htmlEntities($_POST["password"], ENT_QUOTES),
        "confirmpassword" => htmlEntities($_POST["confirmpassword"], ENT_QUOTES),
        "email" => htmlEntities($_POST["email"], ENT_QUOTES),
        "firstname" => htmlEntities($_POST["firstname"], ENT_QUOTES)
    );
    // создаем объект users, в котором хранятся данные всех пользователей из базы данных
    $users = dbConnect();
    // если пользовательские данные проходят проверку на уникальность
    // то переходим к созданию пользователя в базе
    if (checkUnique($userData, $users)){
        $xmldoc = new DomDocument( '1.0' );
        $xmldoc->preserveWhiteSpace = false;
        $xmldoc->formatOutput = true;
        if( $xml = file_get_contents('db/users.xml') ) {
            $xmldoc->loadXML( $xml, LIBXML_NOBLANKS );
            $root = $xmldoc->getElementsByTagName('users')->item(0);
            // создаем <user> и встаявляем его как первый элемент в тэге <users>
            // чтобы не прокручивать файл, а сразу видеть в файле users.xml нового пользователя
            $user = $xmldoc->createElement('user');
            $root->insertBefore( $user, $root->firstChild );
            // создаем <username> и записываем тескт с username
            $usernameElement = $xmldoc->createElement('username');
            $user->appendChild($usernameElement);
            $usernameText = $xmldoc->createTextNode($userData["username"]);
            $usernameElement->appendChild($usernameText);
            // создаем <password>, хэшируем и записываем хэш с password
            $passwordElement = $xmldoc->createElement('password');
            $user->appendChild($passwordElement);
            $passwordText = $xmldoc->createTextNode(hashPassword($userData["password"]));
            $passwordElement->appendChild($passwordText);
            // создаем <email> и записываем текст с email
            $emailElement = $xmldoc->createElement('email');
            $user->appendChild($emailElement);
            $emailText = $xmldoc->createTextNode($userData["email"]);
            $emailElement->appendChild($emailText);
            // создаем <firstname> и записываем текст с firstname
            $firstnameElement = $xmldoc->createElement('firstname');
            $user->appendChild($firstnameElement);
            $firstnameText = $xmldoc->createTextNode($userData["firstname"]);
            $firstnameElement->appendChild($firstnameText);
            // сохраняем
            $xmldoc->save('db/users.xml');
            $result = array(
                "message" => "Вы успешно зарегистрированы. <a href='login.php'>Войти в личный кабинет</a>"
            );
        } else {
            $result = array(
                "message" => "Невозможно подключиться к базе данных"
            );
        }
    } else {
        $result = array(
            "message" => "Такой логин или email уже существуют, попробуйте другие"
        );
    }
};
// Переводим массив с сообщением о результате в JSON
echo json_encode($result);
?>