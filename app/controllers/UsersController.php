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

  public function edit()
  {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $userId = $params["id"];
    $user = $this->userModel->getUserById($userId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Получаем данные из формы
      $id = $_POST['id'];
      $email = $_POST['email'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $phone = $_POST['phone'];

      $foundUser = $this->userModel->getUserById($id);

      // Проверка пользовательского пароля
      if ($foundUser) {
        $response = $this->userModel->updateUser($id, $email, $firstname, $lastname, $phone);
        if ($response) {
          $user = $response;
        } else {
          echo 'Не удалось получить обновлённые данные пользователя';
        }
        echo 'Данные обновленны';
        // header("Location: /users/edit?id=$id"); // редирект на главную страницу
      } else {
        echo 'Пользователь не найден';
      }
    }

    require_once 'app/views/admin/users/edit.php';
  }
}