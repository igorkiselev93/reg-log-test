<?php

// Файл users.xml содержит XML-документ со всеми пользователями
function dbConnect(){
    if (file_exists('db/users.xml')) {
        $users = new SimpleXMLElement('db/users.xml', NULL, TRUE);
        return $users;
    } else {
        exit('Не удалось открыть файл users.xml');
    }
}
// проверка пользовательчкого username и email на уникальность
function checkUnique($userData, $users){
    $unique = true;
    foreach ($users->user as $user) {
        if ($user->username == $userData["username"] || $user->email == $userData["email"]){
            $unique = false;
            break;
        }
    }
    return $unique;
};
function hashPassword($password){
    $salt = "qm&h*pg!@";
    $password = sha1($salt . $password);
    return $password;
};

function checkUsernameAndPassword($userData){
    $check = false;
    $xmldoc = new DomDocument( '1.0' );
    $xmldoc->preserveWhiteSpace = false;
    $xmldoc->formatOutput = true;
    if( $xml = file_get_contents('db/users.xml') ) {
        $xmldoc->loadXML($xml, LIBXML_NOBLANKS);
        $users = $xmldoc->getElementsByTagName('user');
        foreach ($users as $user) {

                if ($user->firstChild->nodeValue == $userData["username"]){
                    if ($user->firstChild->nextSibling->nodeValue == hashPassword($userData["password"])){
                        $check = true;
                        if (!($user->lastChild->previousSibling->nodeName == "cookie" && $user->lastChild->nodeName == "session")){
                            setcookie('username', $userData["username"], time()+(60*60*24),  '/');
                            session_start();
                            $_SESSION['username'] = $userData["username"];
                            $cookieElement = $xmldoc->createElement('cookie');
                            $user->appendChild($cookieElement);
                            $cookieText = $xmldoc->createTextNode($_COOKIE['username']);
                            $cookieElement->appendChild($cookieText);
                            $sessionElement = $xmldoc->createElement('session');
                            $user->appendChild($sessionElement);
                            $sessionText = $xmldoc->createTextNode($_SESSION['username']);
                            $sessionElement->appendChild($sessionText);
                            $xmldoc->save('db/users.xml');
                        }


                        break;
                    }
                }
        }
    }

    return $check;
};
?>