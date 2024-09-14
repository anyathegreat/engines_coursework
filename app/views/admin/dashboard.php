<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_email'])) {
    header("Location: /login");
    exit();
}
?>

<h2>Добро пожаловать, <?php echo $_SESSION['user_email']; ?>!</h2>