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
    $filters = [
      "email" => $params["email"] ?? "",
      "phone" => $params["phone"] ?? "",
      "firstname" => $params["firstname"] ?? "",
      "lastname" => $params["lastname"] ?? "",
      "status" => $params["status"] ?? "",
      "dateFrom" => $params["dateFrom"] ?? "",
      "dateTo" => $params["dateTo"] ?? ""
    ];

    if (!$filters["dateFrom"] || !$filters["dateTo"]) {
      $filters["dateFrom"] = "";
      $filters["dateTo"] = "";
    }

    $ordersObj = $this->orderModel->getAllOrdersWithCustomer($page, $filters);
    $orders = $ordersObj['elements'];
    $pageIndexes = getNearbyPageNumbers($ordersObj['currentPage'], $ordersObj['totalPages']);

    require_once 'app/views/admin/orders/index.php';
  }
}
