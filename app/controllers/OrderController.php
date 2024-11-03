<?php
require_once 'app/models/Order.php';
require_once 'app/models/Customer.php';

class OrderController
{
  private $orderModel;
  private $customerModel;

  public function __construct($db)
  {
    $this->orderModel = new Order($db);
    $this->customerModel = new Customer($db);
  }

  public function index()
  {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $orderId = $params["id"];
    $order = $this->orderModel->getOrderById($orderId);
    $products = $order['products'];
    $customer = $this->customerModel->getCustomerById($order["customerID"]);
    require_once 'app/views/admin/order/index.php';
  }
}