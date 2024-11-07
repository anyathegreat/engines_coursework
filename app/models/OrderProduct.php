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
}