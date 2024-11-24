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

  // public function getAllOrdersWithCustomer()
  // {
  //   // Запрос для получения заказов и информации о клиентах
  //   $queryOrders = "
  //     SELECT 
  //       orders.id AS order_id,
  //       orders.date_created,
  //       orders.date_updated,
  //       orders.status,
  //       customers.id AS customer_id,
  //       customers.email,
  //       customers.firstname,
  //       customers.lastname,
  //       customers.phone
  //     FROM 
  //       orders
  //     LEFT JOIN 
  //       customers ON orders.customerID = customers.id;
  //   ";

  //   $resultOrders = $this->db->query($queryOrders);
  //   $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);

  //   // Вытаскиваем список всех продуктов для полученных заказов
  //   $orderIds = array_column($orders, 'order_id');
  //   $orderIdsString = implode(',', array_map('intval', $orderIds));

  //   // Запрос для получения продуктов, связанных с заказами
  //   $queryProducts = "
  //     SELECT 
  //       order_products.order_id,
  //       order_products.product_id,
  //       order_products.count,
  //       products.id AS product_id,
  //       products.article AS product_article,
  //       products.name AS product_name,
  //       products.description AS product_description,
  //       products.count AS product_count,
  //       products.price AS product_price,
  //       products.engine_id AS product_engine_id
  //     FROM 
  //       order_products
  //     LEFT JOIN 
  //       products ON order_products.product_id = products.id 
  //     WHERE 
  //       order_products.order_id IN ($orderIdsString);
  //   ";

  //   $resultProducts = $this->db->query($queryProducts);
  //   $products = $resultProducts->fetch_all(MYSQLI_ASSOC);

  //   // Формируем ассоциативный массив для связи заказов с продуктами
  //   $productsByOrderId = [];
  //   foreach ($products as $product) {
  //     $productsByOrderId[$product['order_id']][] = [
  //       'id' => $product['product_id'],
  //       'count_in_order' => $product['count'],
  //       'product_article' => $product['product_article'],
  //       'product_name' => $product['product_name'],
  //       'product_description' => $product['product_description'],
  //       'product_count' => $product['product_count'],
  //       'product_price' => $product['product_price'],
  //       'product_engine_id' => $product['product_engine_id'],
  //     ];
  //   }

  //   // Присоединяем продукты к каждому заказу
  //   foreach ($orders as &$order) {
  //     $order['products'] = isset($productsByOrderId[$order['order_id']]) ? $productsByOrderId[$order['order_id']] : [];

  //     $order['price'] = 0;
  //     foreach ($order['products'] as $product) {
  //       $order['price'] += $product['product_price'] * $product['count_in_order'];
  //     }
  //   }

  //   return $orders;
  // }



  // public function getAllOrdersWithCustomer($page = 1, $filters, $limit = 10)
  // {

  //   // Получаем общее количество заказов для расчета totalResults и totalPages
  //   $queryTotal = "SELECT COUNT(*) as total FROM orders LEFT JOIN customers ON orders.customerID = customers.id";

  //   if (!empty(array_filter($filters))) {
  //     $queryTotal .= " WHERE ";

  //     if ($filters['email']) {
  //       $queryTotal .= 'customers.email LIKE "%' . $filters['email'] . '%" AND ';
  //     }
  //     if ($filters['phone']) {
  //       $queryTotal .= 'customers.phone LIKE "%' . $filters['phone'] . '%" AND ';
  //     }
  //     if ($filters['firstname']) {
  //       $queryTotal .= 'customers.firstname LIKE "%' . $filters['firstname'] . '%" AND ';
  //     }
  //     if ($filters['lastname']) {
  //       $queryTotal .= 'customers.lastname LIKE "%' . $filters['lastname'] . '%" AND ';
  //     }
  //     if ($filters['status']) {
  //       $queryTotal .= 'orders.status LIKE "%' . $filters['status'] . '%" AND ';
  //     }
  //     if ($filters['dateFrom'] && $filters['dateTo']) {
  //       $queryTotal .= 'orders.date_created BETWEEN "' . $filters['dateFrom'] . '" AND "' . $filters['dateTo'] . '"';
  //     }

  //     if (str_ends_with($queryTotal, " AND ")) {
  //       $queryTotal = substr($queryTotal, 0, -5);
  //     }
  //     $queryTotal .= ";";
  //   }

  //   $resultTotal = $this->db->query($queryTotal);
  //   $totalData = $resultTotal->fetch_assoc();

  //   $totalResults = $totalData['total'];

  //   // Рассчитываем общее количество страниц
  //   $totalPages = ceil($totalResults / $limit);

  //   if ($page > $totalPages || $page < 1) {
  //     $page = 1;
  //   }

  //   // Вычисляем смещение
  //   $offset = ($page - 1) * $limit;

  //   // Запрос для получения заказов и информации о клиентах с пагинацией
  //   $queryOrders = "
  //     SELECT 
  //       orders.id AS order_id,
  //       orders.date_created,
  //       orders.date_updated,
  //       orders.status,
  //       customers.id AS customer_id,
  //       customers.email,
  //       customers.firstname,
  //       customers.lastname,
  //       customers.phone
  //       FROM 
  //       orders
  //       LEFT JOIN 
  //       customers ON orders.customerID = customers.id
  //       ";

  //   if (!empty(array_filter($filters))) {
  //     $queryOrders .= " WHERE ";

  //     if ($filters['email']) {
  //       $queryOrders .= 'customers.email LIKE "%' . $filters['email'] . '%" AND ';
  //     }
  //     if ($filters['phone']) {
  //       $queryOrders .= 'customers.phone LIKE "%' . $filters['phone'] . '%" AND ';
  //     }
  //     if ($filters['firstname']) {
  //       $queryOrders .= 'customers.firstname LIKE "%' . $filters['firstname'] . '%" AND ';
  //     }
  //     if ($filters['lastname']) {
  //       $queryOrders .= 'customers.lastname LIKE "%' . $filters['lastname'] . '%" AND ';
  //     }
  //     if ($filters['status']) {
  //       $queryOrders .= 'orders.status LIKE "%' . $filters['status'] . '%" AND ';
  //     }
  //     if ($filters['dateFrom'] && $filters['dateTo']) {
  //       $queryOrders .= 'orders.date_created BETWEEN "' . $filters['dateFrom'] . '" AND "' . $filters['dateTo'] . '"';
  //     }

  //     if (str_ends_with($queryOrders, " AND ")) {
  //       $queryOrders = substr($queryOrders, 0, -5);
  //     }
  //     $queryOrders .= "LIMIT $limit OFFSET $offset;";
  //   }

  //   $resultOrders = $this->db->query($queryOrders);
  //   $orders = $resultOrders->fetch_all(MYSQLI_ASSOC);

  //   // Вытаскиваем список всех продуктов для полученных заказов
  //   $orderIds = array_column($orders, 'order_id');

  //   // Проверка наличия заказов
  //   if (empty($orderIds)) {
  //     return [
  //       'elements' => [],
  //       'limit' => $limit,
  //       'totalPages' => 1,
  //       'totalResults' => 0,
  //       'currentPage' => 1
  //     ];
  //   }

  //   $orderIdsString = implode(',', array_map('intval', $orderIds));

  //   // Запрос для получения продуктов, связанных с заказами
  //   $queryProducts = "
  //     SELECT 
  //       order_products.order_id,
  //       order_products.product_id,
  //       order_products.count,
  //       products.id AS product_id,
  //       products.article AS product_article,
  //       products.name AS product_name,
  //       products.description AS product_description,
  //       products.count AS product_count,
  //       products.price AS product_price,
  //       products.engine_id AS product_engine_id
  //     FROM 
  //       order_products
  //     LEFT JOIN 
  //       products ON order_products.product_id = products.id 
  //     WHERE 
  //       order_products.order_id IN ($orderIdsString);
  //   ";

  //   $resultProducts = $this->db->query($queryProducts);
  //   $products = $resultProducts->fetch_all(MYSQLI_ASSOC);

  //   // Формируем ассоциативный массив для связи заказов с продуктами
  //   $productsByOrderId = [];
  //   foreach ($products as $product) {
  //     $productsByOrderId[$product['order_id']][] = [
  //       'id' => $product['product_id'],
  //       'count_in_order' => $product['count'],
  //       'product_article' => $product['product_article'],
  //       'product_name' => $product['product_name'],
  //       'product_description' => $product['product_description'],
  //       'product_count' => $product['product_count'],
  //       'product_price' => $product['product_price'],
  //       'product_engine_id' => $product['product_engine_id'],
  //     ];
  //   }

  //   // Присоединяем продукты к каждому заказу
  //   foreach ($orders as &$order) {
  //     $order['products'] = isset($productsByOrderId[$order['order_id']]) ? $productsByOrderId[$order['order_id']] : [];

  //     $order['price'] = 0;
  //     foreach ($order['products'] as $product) {
  //       $order['price'] += $product['product_price'] * $product['count_in_order'];
  //     }
  //   }


  //   // Возвращаем объект с результатами
  //   return [
  //     'elements' => $orders,
  //     'limit' => $limit,
  //     'totalPages' => $totalPages,
  //     'totalResults' => $totalResults,
  //     'currentPage' => $page
  //   ];
  // }

  public function getAllOrdersWithCustomer($page = 1, $filters, $limit = 10)
  {
    // Получаем общее количество заказов
    $totalResults = $this->getTotalOrdersCount($filters);
    $totalPages = ceil($totalResults / $limit);
    $page = ($page > $totalPages || $page < 1) ? 1 : $page;
    $offset = ($page - 1) * $limit;

    // Получаем заказы и информацию о клиентах
    $orders = $this->getOrders($filters, $limit, $offset);

    if (empty($orders)) {
      return $this->getEmptyResponse($limit, 1);
    }

    // Получаем продукты, связанные с заказами
    $productsByOrderId = $this->getProductsByOrderIds(array_column($orders, 'order_id'));

    // Объединяем продукты с заказами
    $this->attachProductsToOrders($orders, $productsByOrderId);

    return $this->getResponse($orders, $limit, $totalPages, $totalResults, $page);
  }

  private function getTotalOrdersCount($filters)
  {
    $query = "SELECT COUNT(*) as total FROM orders LEFT JOIN customers ON orders.customerID = customers.id";
    $query .= $this->buildFilterQuery($filters);
    $result = $this->db->query($query);
    $totalData = $result->fetch_assoc();

    return $totalData['total'];
  }

  private function getOrders($filters, $limit, $offset)
  {
    $query = "
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
            customers ON orders.customerID = customers.id
    ";
    $query .= $this->buildFilterQuery($filters);
    $query .= " LIMIT $limit OFFSET $offset;";

    $result = $this->db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  private function buildFilterQuery($filters)
  {
    if (empty(array_filter($filters))) {
      return '';
    }

    $conditions = [];
    if ($filters['email'])
      $conditions[] = 'customers.email LIKE "%' . $filters['email'] . '%"';
    if ($filters['phone'])
      $conditions[] = 'customers.phone LIKE "%' . $filters['phone'] . '%"';
    if ($filters['firstname'])
      $conditions[] = 'customers.firstname LIKE "%' . $filters['firstname'] . '%"';
    if ($filters['lastname'])
      $conditions[] = 'customers.lastname LIKE "%' . $filters['lastname'] . '%"';
    if ($filters['status'])
      $conditions[] = 'orders.status LIKE "%' . $filters['status'] . '%"';
    if ($filters['dateFrom'] && $filters['dateTo'])
      $conditions[] = 'orders.date_created BETWEEN "' . $filters['dateFrom'] . '" AND "' . $filters['dateTo'] . '"';

    return ' WHERE ' . implode(' AND ', $conditions);
  }

  private function getProductsByOrderIds($orderIds)
  {
    if (empty($orderIds)) {
      return [];
    }

    $orderIdsString = implode(',', array_map('intval', $orderIds));
    $query = "
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

    $result = $this->db->query($query);
    $products = $result->fetch_all(MYSQLI_ASSOC);

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

    return $productsByOrderId;
  }

  private function attachProductsToOrders(&$orders, $productsByOrderId)
  {
    foreach ($orders as &$order) {
      $order['products'] = $productsByOrderId[$order['order_id']] ?? [];

      $order['price'] = array_reduce($order['products'], function ($carry, $product) {
        return $carry + $product['product_price'] * $product['count_in_order'];
      }, 0);
    }
  }

  private function getEmptyResponse($limit, $page)
  {
    return [
      'elements' => [],
      'limit' => $limit,
      'totalPages' => 1,
      'totalResults' => 0,
      'currentPage' => $page,
    ];
  }

  private function getResponse($orders, $limit, $totalPages, $totalResults, $page)
  {
    return [
      'elements' => $orders,
      'limit' => $limit,
      'totalPages' => $totalPages,
      'totalResults' => $totalResults,
      'currentPage' => $page,
    ];
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