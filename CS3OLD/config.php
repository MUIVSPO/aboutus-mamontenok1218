<?php
$servername = "localhost";
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "mydb"; // Имя базы данных

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Устанавливаем режим ошибок для исключения
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>