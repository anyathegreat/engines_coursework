<?php
class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Получение продукта по id
    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Создание нового продукта
    public function createProduct($article, $name, $description, $price, $count, $engine_id, $img = null)
    {
        $query = "INSERT INTO products (article, name, description, price, count, engine_id, img) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssdiis", $article, $name, $description, $price, $count, $engine_id, $img);
        return $stmt->execute();
    }

    // Обновление продукта
    public function updateProduct($id, $article, $name, $description, $price, $count, $engine_id, $img = null)
    {
        $query = "UPDATE products SET article = ?, name = ?, description = ?, price = ?, count = ?, engine_id = ?, img = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssdiisi", $article, $name, $description, $price, $count, $engine_id, $img, $id);
        return $stmt->execute();
    }

    // Удаление продукта
    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
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