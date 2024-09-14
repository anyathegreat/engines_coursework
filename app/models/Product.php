<?php
class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Создание нового продукта
    public function createProduct($article, $name, $description, $price, $count, $engine_id, $img = null)
    {
        $query = "INSERT INTO products (article, name, description, price, count, engine_id, img) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssdiss", $article, $name, $description, $price, $count, $engine_id, $img);
        return $stmt->execute();
    }

    // Получение продукта по ID
    public function findProductById($id)
    {
        $query = "SELECT * FROM products WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Обновление продукта
    public function updateProduct($id, $article, $name, $description, $price, $count, $engine_id, $img = null)
    {
        $query = "UPDATE products SET article = ?, name = ?, description = ?, price = ?, count = ?, engine_id = ?, img = ? WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssdissi", $article, $name, $description, $price, $count, $engine_id, $img, $id);
        return $stmt->execute();
    }

    // Удаление продукта
    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE ID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Получение всех продуктов
    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}