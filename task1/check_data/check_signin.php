<?php
session_start();
require_once "../dbsetting.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
        $sql = 'SELECT `password` FROM `users` WHERE `login` = :u_login';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([':u_login' => $_POST['login']]);
        if ($stmt->rowCount() && password_verify($_POST['password'], $stmt->fetch()['password'])) {
            $_SESSION['login'] = $_POST['login'];
            header('Location: ../pages/account.php');
        } else {
            echo "<h1>Некорректний логін або пароль! Спробуйте ще раз</h1>";
            echo "<a href='../pages/index.php'>Повернутись на головну</a>";
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}