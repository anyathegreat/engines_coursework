<?php
require_once 'app/models/Product.php'; // Не забудьте подключить файл с классом Product

class CatalogController
{
    private $productModel;

    public function __construct($db)
    {
        $this->productModel = new Product($db);
    }

    public function index()
    {
        // Вызываем метод для получения всех продуктов
        $products = $this->productModel->getAllProducts();

        require_once 'app/views/catalog.php';
    }
}
