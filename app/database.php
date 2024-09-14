<?php
$host = 'localhost'; // Хост
$user = 'engines'; // Пользователь
$password = 'RZe-u5C-ArZ-5SY'; // Пароль
$db_name = 'engines'; // Имя базы данных

// Создаем соединение
$mysqli = new mysqli($host, $user, $password, $db_name);

// Проверяем соединение
if ($mysqli->connect_errno) {
    echo "Ошибка подключения к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}