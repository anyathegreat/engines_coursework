<?php
class Order
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  // Получение продукта по id
  public function getOrderById($id)
  {
    $query = "SELECT * FROM orders WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
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
        customers ON orders.customerID = customers.id;
    ";
    $result = $this->db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}