<?php
// открываем сессию, чтобы проверить не залогинился ли уже пользователь
session_start();
// получаем всех пользователей из базы данных
function getUsersFromDB (){
    $xmldoc = new DomDocument( '1.0' );
    $xmldoc->preserveWhiteSpace = false;
    $xmldoc->formatOutput = true;
    if( $xml = file_get_contents('db/users.xml') ) {
        $xmldoc->loadXML($xml, LIBXML_NOBLANKS);
        $users = $xmldoc->getElementsByTagName('user');
    }
    return $users;
}
// проверяем значение username из сессии
if (!empty($_SESSION['username'])) {
    $users = getUsersFromDB();
    foreach ($users as $user) {
        if ($user->firstChild->nodeValue == $_SESSION['username']) {
            echo "Hello " . $_SESSION['username'];
            break;
        }
    }
} else {
    // проверяем наличие кук
    if (!empty($_COOKIE['username'])) {
        $users = getUsersFromDB();
        foreach ($users as $user) {
            if ($user->firstChild->nodeValue == $_COOKIE['username']) {
                echo "Hello " . $_COOKIE['username'];
                break;
            }
        }
    }
    else {?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <p>Добро пожаловать на наш сайт!</p>
    <p>
        <a href="registr.php">Регистрация |</a>
        <a href="login.php">Вход</a>
    </p>
</div>
</body>
</html>

<?php }
}

?>