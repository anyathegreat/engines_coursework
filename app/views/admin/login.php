<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_email'])) {
    header("Location: /dashboard");
    exit();
}
?>

<h1>Вход</h1>
<form action="" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>