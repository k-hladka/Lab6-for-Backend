<?php
session_start();
require_once '../dbsetting.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pattern_name = "|[\d@#\s$%!\"'^&*()+=~:><.,_{}\[\]?/\\|`№;]|";
    $pattern_login = "|[@#$%!\"'^&*()+=~:><,{}\[\]?/\\|`№;]|";
    $pattern_email = "|[><()\[\]\s,;:/\\\'\"`*{}]|";

    try {
        $conn = new PDO("mysql: host=$servername; dbname=$dbname", $username, $password, $opt);

        if (
            strlen($_POST['email']) >= 4 &&
            strlen($_POST['email']) <= 256 &&
            preg_match($pattern_email, $_POST['email']) == 0 &&
            substr_count($_POST['email'], '@') == 1
        ) {
            $sql = "SELECT `email` FROM `users` WHERE `email` = :email";
            $stmt = $conn->prepare($sql);
            $row = $stmt->execute([':email' => $_POST['email']]);

            if ($stmt->rowCount() == 0)
                $user_email = $_POST['email'];
            else {
                echo "<h1>Користувач з такою поштою вже зареєстрований!</h1>";
                echo "<a href='../pages/index.php'>На головну</a>";
                exit;
            }

        } else {
            echo "<h1>Некорректна пошта! Спробуйте ще раз</h1>";
            header_to_register();
            exit;
        }


        if ($_POST['age'] >= 6 && $_POST['age'] <= 100)
            $user_age = $_POST['age'];
        else {
            echo "<h1>Некорректний вік! Спробуйте ще раз</h1>";
            header_to_register();
            exit;
        }


        if (strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 30 && preg_match($pattern_name, $_POST['name']) == 0)
            $user_name = $_POST['name'];
        else {
            echo "<h1>Некорректне ім'я! Спробуйте ще раз</h1>";
            echo "<h4><span style='color: red'>Перевірте, чи Ваше ім'я не містить недопустимих символів (цифри, пробіли, знаки пунктуації, тощо).</span></h4>";
            header_to_register();
            exit;
        }


        if (strlen($_POST['surname']) >= 4 && strlen($_POST['surname']) <= 30 && preg_match($pattern_name, $_POST['surname']) == 0)
            $user_surname = $_POST['surname'];
        else {

            echo "<h1>Некорректне прізвище! Спробуйте ще раз</h1>";
            echo "<h4><span style='color: red'>Перевірте, чи Ваше прізвище не містить недопустимих символів (цифри, пробіли, знаки пунктуації, тощо).</span></h4>";
            header_to_register();
            exit;
        }


        if (strlen($_POST['login']) >= 3 && strlen($_POST['login']) <= 20 && preg_match($pattern_login, $_POST['surname']) == 0) {
            $sql = "SELECT `login` FROM `users` WHERE `login` = :login";
            $stmt = $conn->prepare($sql);
            $row = $stmt->execute([':login' => $_POST['login']]);
            if (($stmt->rowCount() == 0 && !isset($_GET['upd'])) || ($stmt->rowCount() == 1 && isset($_GET['upd'])))
                $user_login = $_POST['login'];
            else {
                echo "<h1>Вже існує користувач з таким логіном!</h1>";
                header_to_register();
                exit;
            }
        } else {

            echo "<h1>Некорректний логін! Спробуйте ще раз</h1>";
            echo "<h4><span style='color: red'>Перевірте, чи Ваш логін не містить недопустимих символів (цифри, пробіли, знаки пунктуації, тощо).</span></h4>";
            header_to_register();
            exit;
        }


        if (strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 16)
            $user_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        else {
            echo "<h1>Некорректна довжина паролю! Спробуйте ще раз</h1>";
            header_to_register();
            exit;
        }


        if (isset($_GET['upd']))
            $sql = "UPDATE `users` SET login = :u_login, password = :u_password, name = :u_name, surname = :u_surname, age = :u_age, email = :u_email";
        else
            $sql = "INSERT INTO `users` (login, password, name, surname, age, email) VALUES (:u_login, :u_password, :u_name, :u_surname, :u_age, :u_email)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':u_login' => $user_login, ':u_password' => $user_password, ':u_name' => $user_name,
            ':u_surname' => $user_surname, ':u_age' => $user_age, ':u_email' => $user_email]);

        if (isset($_GET['upd'])) {
            echo "<h1>Дані успішно змінені!</h1>";
            session_unset();
        } else
            echo "<h1>Реєстрація пройшла успішно!</h1>";

        echo "<a href='../pages/index.php'>На головну</a>";

    } catch (PDOException $e) {
        print $e->getMessage();
    }
}

function header_to_register()
{
    if (isset($_GET['upd']))
        echo "<a href='../pages/form_register.php?upd=1'>До реєстрації</a>";
    else
        echo "<a href='../pages/form_register.php'>До реєстрації</a>";
}