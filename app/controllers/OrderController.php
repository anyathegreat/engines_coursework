<?php
require_once 'app/models/Order.php';
require_once 'app/models/Customer.php';
require_once 'app/models/OrderProduct.php';
require_once 'app/models/Product.php';

class OrderController
{
  private $orderModel;
  private $orderProductModel;
  private $customerModel;
  private $productModel;

  public function __construct($db)
  {
    $this->orderModel = new Order($db);
    $this->customerModel = new Customer($db);
    $this->orderProductModel = new OrderProduct($db);
    $this->productModel = new Product($db);
  }

  public function index()
  {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $orderId = $params["id"];
    $order = $this->orderModel->getOrderWithProductsById($orderId);
    $products = $order['products'];
    $customer = $this->customerModel->getCustomerById($order["customerID"]);
    require_once 'app/views/admin/order/index.php';
  }

  public function editProducts()
  {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $orderId = $params["id"];

    $orderProducts = $this->orderProductModel->getOrderProductsById($orderId);
    $allProducts = $this->productModel->getAllProducts();

    $allProductsMin = array_map(function ($product) {
      unset($product['description']);
      unset($product['img']);
      unset($product['engine_id']);

      return $product;
    }, $allProducts);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['orderId'];
      $productCodes = $_POST['productCodes'] ?? [];

      try {
        // Вызываем метод создания пользователя
        if (empty($productCodes)) {
          $this->orderProductModel->deleteOrderProducts($id);
        } else {
          $this->orderProductModel->updateOrderProducts($id, $productCodes);
        }

        $this->orderModel->refreshDateUpdated($id);

        // Параметры для страницы успеха
        $title = "Товары обновлены";
        $message = "Вы успешно обновили товары";
        $redirect_url = "/order?id=$id";

        // Включаем страницу успеха
        include 'app/views/messageSuccess.php';
        return;
      } catch (Exception $e) {
        // Обрабатываем исключение и передаем сообщение об ошибке
        $errorMessage = $e->getMessage();
      }
    }

    require_once 'app/views/admin/order/editProducts.php';
  }

  public function edit()
  {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $orderId = $params["id"];

    $order = $this->orderModel->getOrderWithProductsById($orderId);

    require_once 'app/views/admin/order/edit.php';
  }

  public function delete()
  {
    // Получение id товара из URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $orderId = $params["id"];

    // Проверка существования товара
    $order = $this->orderModel->getOrderById($orderId);
    if (!$order) {
      // Если товар не найден, отображаем сообщение на странице успеха
      $title = "Ошибка";
      $message = "Заказ не найден.";
      $redirect_url = "/orders";
      include 'app/views/messageFailure.php'; // Переход на страницу успеха с сообщением
      return;

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Удаление товара
      $response = $this->orderModel->deleteOrder($orderId);

      if ($response) {
        // Если удаление прошло успешно
        $title = "Заказ удалён";
        $message = "Заказ успешно удалён.";
        $redirect_url = "/orders";
        include 'app/views/messageSuccess.php'; // Переход на страницу успеха
        return;
      } else {
        // Если удаление не удалось
        $title = "Ошибка";
        $message = "Не удалось удалить заказ.";
        $redirect_url = "/orders";
        include 'views/messageFailure.php'; // Переход на страницу успеха с сообщением об ошибке
        return;
      }
    }

    // Отображение формы удаления, если это не DELETE-запрос
    require_once 'app/views/admin/order/delete.php';
  }
}