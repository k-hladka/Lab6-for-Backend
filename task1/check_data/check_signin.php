<?php
session_start();
require_once "../dbsetting.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
        $sql = 'SELECT `password` FROM `users` WHERE `login` = :u_login';
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([':u_login' => $_POST['login']]);
        if (password_verify($_POST['password'], $stmt->fetch()['password'])) {
            $_SESSION['login'] = $_POST['login'];
            header('Location: account.php');
        } else {
            echo "<h1>Некорректний лонін або пароль! Спробуйте ще раз</h1>";
            echo "<a href='../pages/index.php'>Повернутись на головну</a>";
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}