<?php
class Engine
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getAllEngines()
  {
    $query = "SELECT * FROM engines";
    $result = $this->db->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}