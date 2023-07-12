<?php
session_start();
require_once "../dbsetting.php";

try {
    $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);
    $sql = 'DELETE FROM `users` WHERE `login` = :u_login';
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute([':u_login' => $_SESSION['login']]);

    session_unset();
    header('Location: index.php');
} catch (PDOException $e) {
    echo $e->getMessage();
}