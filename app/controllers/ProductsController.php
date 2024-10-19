<?php
require_once 'app/models/Product.php'; // Не забудьте подключить файл с классом Product
require_once 'app/models/Engine.php'; // Не забудьте подключить файл с классом Engine

class ProductsController
{
  private $productModel;
  private $engineModel;


  public function __construct($db)
  {
    $this->productModel = new Product($db);
    $this->engineModel = new Engine($db);
  }

  public function index()
  {
    // Вызываем метод для получения всех продуктов
    $products = $this->productModel->getAllProducts();
    $engines = $this->engineModel->getAllEngines();

    require_once 'app/views/admin/products/index.php';
  }

  public function create()
  {
    // Вызываем метод для получения всех двигателей
    $engines = $this->engineModel->getAllEngines();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Получение данных из формы
      $article = $_POST['article'];
      $name = $_POST['name'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $count = "0";

      $engine_id = $_POST['engine_id'];
      if ($engine_id == "") {
        $engine_id = null;
      }

      $img = null;
      $file = $_FILES['img'] ?? null;
      if ($file['tmp_name']) {
        $img = file_get_contents($file['tmp_name']);
      }

      try {
        // Вызываем метод создания товара
        $this->productModel->createProduct($article, $name, $description, $price, $count, $engine_id, $img);

        // Параметры для страницы успеха
        $title = "Товар создан";
        $message = "Вы успешно создали товар с артикулом: " . htmlspecialchars($article) . ".";
        $redirect_url = "/products";

        // Включаем страницу успеха
        include 'app/views/messageSuccess.php';
        return;
      } catch (Exception $e) {
        // Обрабатываем исключение и передаем сообщение об ошибке
        $errorMessage = $e->getMessage();
      }
    }

    // Если это не POST-запрос, выводим форму для создания пользователя
    require_once 'app/views/admin/products/create.php';
  }

  public function edit()
  {
    // Получение id товара из URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $productId = $params["id"];
    $product = $this->productModel->getProductById($productId);
    $engines = $this->engineModel->getAllEngines();

    // Проверка, существует ли пользователь
    if (!$product) {
      // Если товар не найден, можно отображать сообщение или перенаправлять
      $title = "Ошибка";
      $message = "Товар не найден.";
      $redirect_url = "/products";
      include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Получение данных из формы
      $id = $_POST['id'];
      $article = $_POST['article'];
      $name = $_POST['name'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $count = $_POST['count'];

      $engine_id = $_POST['engine_id'];
      if ($engine_id == "") {
        $engine_id = null;
      }

      $img = null;
      $file = $_FILES['img'] ?? null;
      if ($file['tmp_name']) {
        $img = file_get_contents($file['tmp_name']);
      }

      // Обновление данных пользователя
      $response = $this->productModel->updateProduct($id, $article, $name, $description, $price, $count, $engine_id, $img);

      if ($response) {
        // Если обновление прошло успешно
        $title = "Данные обновлены";
        $message = "Поля товара успешно обновлены.";
        $redirect_url = "/products";
        include 'app/views/messageSuccess.php'; // Переход на страницу успеха
        return;
      } else {
        // Если обновление не удалось
        $title = "Ошибка";
        $message = "Не удалось обновить поля товара.";
        $redirect_url = "/products";
        include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
        return;
      }
    }

    require_once 'app/views/admin/products/edit.php';
  }

  public function delete()
  {
    // Получение id товара из URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $productId = $params["id"];

    // Проверка существования товара
    $product = $this->productModel->getProductById($productId);
    if (!$product) {
      // Если товар не найден, отображаем сообщение на странице успеха
      $title = "Ошибка";
      $message = "Товар не найден.";
      $redirect_url = "/products";
      include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением
      return;

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Удаление товара
      $response = $this->productModel->deleteProduct($productId);

      if ($response) {
        // Если удаление прошло успешно
        $title = "Товар удалён";
        $message = "Товар успешно удалён.";
        $redirect_url = "/products";
        include 'app/views/messageSuccess.php'; // Переход на страницу успеха
        return;
      } else {
        // Если удаление не удалось
        $title = "Ошибка";
        $message = "Не удалось удалить товар.";
        $redirect_url = "/products";
        include 'views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
        return;
      }
    }

    // Отображение формы удаления, если это не DELETE-запрос
    require_once 'app/views/admin/products/delete.php';
  }
}
