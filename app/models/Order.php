<?php
class Order
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getOrderById($id)
  {
    $queryOrder = "SELECT * FROM orders WHERE id = ?";

    $stmt = $this->db->prepare($queryOrder);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  // Получение продукта по id
  public function getOrderWithProductsById($id)
  {
    $queryOrder = "SELECT * FROM orders WHERE id = ?";

    $stmt = $this->db->prepare($queryOrder);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $orderId = $order['id'];

    $queryProducts = "
      SELECT 
        order_products.order_id,
        order_products.product_id,
        order_products.count,
        products.id AS product_id,
        products.article AS product_article,
        products.name AS product_name,
        products.description AS product_description,
        products.count AS product_count,
        products.price AS product_price,
        products.engine_id AS product_engine_id
      FROM 
        order_products
      LEFT JOIN 
        products ON order_products.product_id = products.id 
      WHERE 
        order_products.order_id IN ($orderId);
    ";

    $resultProducts = $this->db->query($queryProducts);
    $products = $resultProducts->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $key => $product) {
      $products[$key] = [
        'id' => $product['product_id'],
        'count_in_order' => $product['count'],
        'product_article' => $product['product_article'],
        'product_name' => $product['product_name'],
        'product_description' => $product['product_description'],
        'product_count' => $product['product_count'],
        'product_price' => $product['product_price'],
        'product_engine_id' => $product['product_engine_id'],
      ];
    }

    // Присоединяем продукты к каждому заказу
    $order['products'] = isset($products) ? $products : [];

    $order['price'] = 0;
    foreach ($order['products'] as $product) {
      $order['price'] += $product['product_price'] * $product['count_in_order'];
    }

    return $order;
  }

  // Получение всех продуктов
  public function getAllOrders(): mixed
  {
    $query = "SELECT * FROM orders";
    $result = $this->db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getAllOrdersWithCustomer()
  {
    // Запрос для получения заказов и информации о клиентах
    $queryOrders = "
      SELECT 
        orders.id AS order_id,
        orders.date_created,
        orders.date_updated,
        orders.status,
        customers.id AS customer_id,
        customers.email,
        customers.firstname,
        customers.lastname,
        customers.phone
      FROM 
        orders
      LEFT JOIN 
        customers ON orders.customerID = customers.id;
    ";

    $resultOrders = $this->db->query($queryOrders);
    $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);

    // Вытаскиваем список всех продуктов для полученных заказов
    $orderIds = array_column($orders, 'order_id');
    $orderIdsString = implode(',', array_map('intval', $orderIds));

    // Запрос для получения продуктов, связанных с заказами
    $queryProducts = "
      SELECT 
        order_products.order_id,
        order_products.product_id,
        order_products.count,
        products.id AS product_id,
        products.article AS product_article,
        products.name AS product_name,
        products.description AS product_description,
        products.count AS product_count,
        products.price AS product_price,
        products.engine_id AS product_engine_id
      FROM 
        order_products
      LEFT JOIN 
        products ON order_products.product_id = products.id 
      WHERE 
        order_products.order_id IN ($orderIdsString);
    ";

    $resultProducts = $this->db->query($queryProducts);
    $products = $resultProducts->fetch_all(MYSQLI_ASSOC);

    // Формируем ассоциативный массив для связи заказов с продуктами
    $productsByOrderId = [];
    foreach ($products as $product) {
      $productsByOrderId[$product['order_id']][] = [
        'id' => $product['product_id'],
        'count_in_order' => $product['count'],
        'product_article' => $product['product_article'],
        'product_name' => $product['product_name'],
        'product_description' => $product['product_description'],
        'product_count' => $product['product_count'],
        'product_price' => $product['product_price'],
        'product_engine_id' => $product['product_engine_id'],
      ];
    }

    // Присоединяем продукты к каждому заказу
    foreach ($orders as &$order) {
      $order['products'] = isset($productsByOrderId[$order['order_id']]) ? $productsByOrderId[$order['order_id']] : [];

      $order['price'] = 0;
      foreach ($order['products'] as $product) {
        $order['price'] += $product['product_price'] * $product['count_in_order'];
      }
    }

    return $orders;
  }

  public function deleteOrder($id)
  {
    $queryOrderProducts = "DELETE FROM order_products WHERE order_id = ?";
    $stmtOrderProducts = $this->db->prepare($queryOrderProducts);
    $stmtOrderProducts->bind_param("i", $id);
    $stmtOrderProducts->execute();

    $queryOrder = "DELETE FROM orders WHERE id = ?";
    $stmtOrder = $this->db->prepare($queryOrder);
    $stmtOrder->bind_param("i", $id);

    return $stmtOrder->execute();
  }
}