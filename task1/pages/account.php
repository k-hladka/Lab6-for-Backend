<?php
session_start();
include_once "../dbsetting.php";

try {
    $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
    $sql = 'SELECT `name` FROM `users` WHERE `login` = :u_login';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute([':u_login' => $_SESSION['login']]);

    echo "<h2>Привіт, ". $stmt->fetch()['name'] ."!</h2><hr>
          <a href='account_data.php'>Переглянути свої дані</a><br>
          <a href='form_register.php?upd=1'>Редагувати свої дані</a><br>
          <a href='#'>Вийти з профілю</a><br>
          <a href='#'>Видалити профіль</a><br>";
} catch (PDOException $e) {
    echo $e->getMessage();
}

