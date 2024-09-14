<?php
require_once 'app/models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findUserByEmail($email);

            // Проверка пользовательского пароля
            if ($user && password_verify($password, $user['password_hash'])) {
                // Успешный вход
                $_SESSION['user_email'] = $user['email'];
                header('Location: /dashboard'); // редирект на главную страницу
                exit;
            } else {
                echo 'Неправильный email или пароль';
            }
        }

        // Подключаем представление для входа
        require_once 'app/views/admin/login.php';
    }

    public function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        session_destroy();
        header('Location: /login'); // редирект на главную страницу
        exit;
    }
}
