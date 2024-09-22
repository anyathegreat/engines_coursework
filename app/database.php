<?php
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$db_name = DB_NAME;

// Создаем соединение
$mysqli = new mysqli($host, $user, $password, $db_name);

// Проверяем соединение
if ($mysqli->connect_errno) {
    echo "Ошибка подключения к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}