<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Успешная авторизация
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.html");
                exit();
            } else {
                // Неверные учетные данные
                echo "Неверное имя пользователя или пароль.";
            }
        } catch (PDOException $e) {
            echo "Ошибка соединения с базой данных: " . $e->getMessage();
        }
    } else {
        echo "Пожалуйста, заполните все поля.";
    }
}
?>