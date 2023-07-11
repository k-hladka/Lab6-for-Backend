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
    <title>Document</title>
</head>
<body>

<?php
try {
    $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
    $sql = 'SELECT * FROM `users` WHERE `login` = :u_login';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute([':u_login' => $_SESSION['login']]);
    $row = $stmt->fetch();
    ?>

    <table class='account_data'>
        <tr>
            <th>Прізвище</th>
            <th>Ім'я</th>
            <th>Вік</th>
            <th>Логін</th>
            <th>Пошта</th>
        </tr>
        <tr>
            <td><?= $row['surname'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= $row['login'] ?></td>
            <td><?= $row['email'] ?></td>
        </tr>
    </table>

    <?php
    echo "<a href='account.php'>Повернутись до профілю</a>";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
</body>
</html>


