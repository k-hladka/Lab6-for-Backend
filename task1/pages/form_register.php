<?php
session_start();
include_once "../dbsetting.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Реєстрація</title>
</head>
<body>
<?php
$readonly = "";
$value_email = "";
$value_login = "";
$button = "Зареєструватись";
$action = "../check_data/check_register.php?";

if (isset($_GET['upd'])) {
    $action = "../check_data/check_register.php?upd=1";
    $readonly = "readonly";

    try {
        $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
        $sql = 'SELECT `email` FROM `users` WHERE `login` = :u_login';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([':u_login' => $_SESSION['login']]);

        $value_email = $stmt->fetch()['email'];
        $value_login = $_SESSION['login'];
        $button = "Внести зміни";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

} ?>

<form action= <?= $action; ?> name="register" method="post">
    <div>
        <label for="name">Ім'я:
            <input type="text" name="name" required minlength="2" maxlength="30">
    </div>
    <div>
        <label for="surname">Прізвище:
            <input type="text" name="surname" required minlength="4" maxlength="30">
    </div>
    <div>
        <label for="email">Пошта:
            <input type="email" name="email" min="4" max="256" required
                   value=<?= $value_email; ?> <?= $readonly; ?>>
    </div>
    <div>
        <label for="login">Логін:
            <input type="text" name="login" required minlength="6" maxlength="20"
                   value=<?= $value_login; ?> <?= $readonly; ?>>
    </div>
    <div>
        <label for="password">Пароль:
            <input type="password" name="password" required minlength="6" maxlength="16">
    </div>
    <div>
        <label for="age">Вік:
            <input type="number" name="age" min="6" max="100" required>
    </div>
    <div>
        <button><?= $button ?></button>
    </div>
    <div>Вже зареєстровані?
        <a href="index.php">На головну</a>
    </div>
</form>
</body>
</html>
