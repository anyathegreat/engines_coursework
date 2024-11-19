<?php
class Customer
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getAllCustomers()
  {
    $query = "SELECT * FROM customers";
    $result = $this->db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getCustomerById($id)
  {
    $query = "SELECT * FROM customers WHERE id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

}
