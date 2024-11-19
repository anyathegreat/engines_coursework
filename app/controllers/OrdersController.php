<?php
require_once 'app/models/Order.php';

class OrdersController
{
  private $orderModel;

  public function __construct($db)
  {
    $this->orderModel = new Order($db);
  }

  public function index()
  {
    $orders = $this->orderModel->getAllOrdersWithCustomer();
    require_once 'app/views/admin/orders/index.php';
  }
}
