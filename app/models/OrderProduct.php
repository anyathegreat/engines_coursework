<?php
class OrderProduct
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getOrderProductsById($orderId)
  {
    $query = "
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
        order_products.order_id IN (?);
    ";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?: [];
  }

  public function updateOrderProducts($id, $products)
  {
    $values = "";
    foreach ($products as $product) {
      $productParts = explode("-", $product);
      $values .= "($id, $productParts[0], $productParts[1]),";
    }
    $values = rtrim($values, ",");

    $query1 = "DELETE FROM order_products WHERE order_id = ?;";
    $query2 = "INSERT INTO order_products (order_id, product_id, count) VALUES $values;";

    $stmt1 = $this->db->prepare($query1);
    $stmt2 = $this->db->prepare($query2);

    if ($stmt1 === false || $stmt2 === false) {
      throw new Exception("Ошибка подготовки запроса: " . $this->db->error);
    }

    $stmt1->bind_param("i", $id);
    $result1 = $stmt1->execute();
    $stmt1->close();

    if (!$result1) {
      $stmt2->close();
      throw new Exception("Не удалось обновить товары");
    }

    $result2 = $stmt2->execute();
    $stmt2->close();

    if (!$result2) {
      throw new Exception("Произошла ошибка при формировании списка товаров, список был очищен");
    }

    return true;
  }

  public function deleteOrderProducts($orderId)
  {
    $query = "DELETE FROM order_products WHERE order_id = ?;";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $orderId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }
}