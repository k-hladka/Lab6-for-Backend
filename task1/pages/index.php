<?php
session_start();
if(isset($_SESSION['succesSignin'])){
header('Location: account.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Вхід</title>
</head>
<body>
<form action="../check_data/check_signin.php" method="post" name="signin">
    <div>
        <label for="login">Введіть логін:
            <input type="text" name="login" required minlength="6" maxlength="20">
    </div>
    <div>
        <label for="password">Введіть пароль:
            <input type="password" name="password" required minlength="6" maxlength="16">
    </div>
    <div>
        <button>Увійти</button>
    </div>
    <div>
        Ще не зареєстровані?
        <a href="form_register.php">Зареєструватись</a>
    </div>
</form>
</body>
</html>
