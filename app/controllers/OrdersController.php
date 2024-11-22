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
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    $page = $params['page'] ?? 1;

    $ordersObj = $this->orderModel->getAllOrdersWithCustomer($page);
    $orders = $ordersObj['elements'];
    $pageIndexes = getNearbyPageNumbers($ordersObj['currentPage'], $ordersObj['totalPages']);

    require_once 'app/views/admin/orders/index.php';
  }
}
