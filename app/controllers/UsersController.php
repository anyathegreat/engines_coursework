<?php
require_once 'app/models/User.php';
class UsersController
{
  private $userModel;

  public function __construct($db)
  {
    $this->userModel = new User($db);
  }

  public function index()
  {
    $users = $this->userModel->getAllUsers();

    require_once 'app/views/admin/users/index.php';
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Получаем данные из POST-запроса
      $email = $_POST['email'] ?? '';
      $firstname = $_POST['firstname'] ?? '';
      $lastname = $_POST['lastname'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $password = $_POST['password'] ?? '';
      $password_confirm = $_POST['password_confirm'] ?? '';
      $role = $_POST['role'] ?? 'user';

      try {
        // Вызываем метод создания пользователя
        $this->userModel->createUser($email, $firstname, $lastname, $phone, $password, $password_confirm, $role);

        // Параметры для страницы успеха
        $title = "Пользователь создан";
        $message = "Вы успешно создали пользователя с email: " . htmlspecialchars($email) . ".";
        $redirect_url = "/users";

        // Включаем страницу успеха
        include 'app/views/messageSuccess.php';
        return;
      } catch (Exception $e) {
        // Обрабатываем исключение и передаем сообщение об ошибке
        $errorMessage = $e->getMessage();
      }
    }

    // Если это не POST-запрос, выводим форму для создания пользователя
    require_once 'app/views/admin/users/create.php';
  }


  public function edit()
  {
    // Получение ID пользователя из URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $userId = $params["id"];
    $user = $this->userModel->getUserById($userId);

    // Проверка, существует ли пользователь
    if (!$user) {
      // Если пользователь не найден, можно отображать сообщение или перенаправлять
      $title = "Ошибка";
      $message = "Пользователь не найден.";
      $redirect_url = "/users";
      include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Получение данных из формы
      $id = $_POST['id'];
      $email = $_POST['email'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $phone = $_POST['phone'];

      // Обновление данных пользователя
      $response = $this->userModel->updateUser($id, $email, $firstname, $lastname, $phone);

      if ($response) {
        // Если обновление прошло успешно
        $title = "Данные обновлены";
        $message = "Данные пользователя успешно обновлены.";
        $redirect_url = "/users";
        include 'app/views/messageSuccess.php'; // Переход на страницу успеха
        return;
      } else {
        // Если обновление не удалось
        $title = "Ошибка";
        $message = "Не удалось обновить данные пользователя.";
        $redirect_url = "/users";
        include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
        return;
      }
    }

    // Отображение формы редактирования, если это не POST-запрос
    require_once 'app/views/admin/users/edit.php';
  }

  public function delete()
  {
    // Получение ID пользователя из URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $userId = $params["id"];

    // Проверка существования пользователя
    $user = $this->userModel->getUserById($userId);
    if (!$user) {
      // Если пользователь не найден, отображаем сообщение на странице успеха
      $title = "Ошибка";
      $message = "Пользователь не найден.";
      $redirect_url = "/users";
      include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением
      return;

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Удаление пользователя
      $response = $this->userModel->deleteUser($userId);

      if ($response) {
        // Если удаление прошло успешно
        $title = "Пользователь удалён";
        $message = "Пользователь успешно удалён.";
        $redirect_url = "/users";
        include 'app/views/messageSuccess.php'; // Переход на страницу успеха
        return;
      } else {
        // Если удаление не удалось
        $title = "Ошибка";
        $message = "Не удалось удалить пользователя.";
        $redirect_url = "/users";
        include 'views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
        return;
      }
    }

    // Отображение формы удаления, если это не DELETE-запрос
    require_once 'app/views/admin/users/delete.php';
  }


  // public function edit()
  // {
  //   parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
  //   $userId = $params["id"];
  //   $user = $this->userModel->getUserById($userId);

  //   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //     // Получаем данные из формы
  //     $id = $_POST['id'];
  //     $email = $_POST['email'];
  //     $firstname = $_POST['firstname'];
  //     $lastname = $_POST['lastname'];
  //     $phone = $_POST['phone'];

  //     $foundUser = $this->userModel->getUserById($id);

  //     // Проверка пользовательского пароля
  //     if ($foundUser) {
  //       $response = $this->userModel->updateUser($id, $email, $firstname, $lastname, $phone);
  //       if ($response) {
  //         $user = $response;
  //       } else {
  //         echo 'Не удалось получить обновлённые данные пользователя';
  //       }
  //       echo 'Данные обновленны';
  //       // header("Location: /users/edit?id=$id"); // редирект на главную страницу
  //     } else {
  //       echo 'Пользователь не найден';
  //     }
  //   }

  //   require_once 'app/views/admin/users/edit.php';
  // }
}