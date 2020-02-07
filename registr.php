<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
</head>
<body>
<div class="container">
    <h2>Регистрация</h2>
    <p class="alert-result-reg" role="alert"></p>
    <form class="form-signin" id="ajax_form" method="post" action="">
        <input class="form-control" type="text" name="username" placeholder="Ваш логин" required>
        <input class="form-control" type="text" name="password" placeholder="Ваш пароль" required>
        <input class="form-control" type="text" name="confirmpassword" placeholder="Подтвердите пароль" required>
        <input class="form-control" type="text" name="email" placeholder="email" required>
        <input class="form-control" type="text" name="firstname" placeholder="Имя" required>
        <button class="btn btn-registr btn-primary btn-block" type="submit">Зарегаться</button>
    </form>
    <div id="result_form"></div>
</div>
</body>
</html>