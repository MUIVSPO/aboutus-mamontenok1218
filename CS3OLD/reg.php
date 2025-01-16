<?php
require_once 'config.php'; // Подключение к базе данных

try {
    // Проверка на наличие данных
    if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
        throw new Exception("Все поля формы должны быть заполнены.");
    }

    // Получение данных из формы
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Проверка корректности email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Неверный формат email.");
    }

    // Хэширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL запрос для вставки данных
    $sql = "INSERT INTO users (email, username, password) 
            VALUES (:email, :username, :password)";

    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        // Успешная регистрация
        header("Location: index.html");
        exit();
    } else {
        throw new Exception("Произошла ошибка при регистрации.");
    }
} catch (Exception $e) {
    // Обработка ошибок
    echo "Ошибка: " . $e->getMessage();
}
?>
