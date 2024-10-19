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
        foreach ($products as &$product) {
            if ($product['img']) {
                $product['img'] = 'data:image/jpeg;base64,' . base64_encode($product['img']);
            } else {
                $product['img'] = 'https://via.placeholder.com/100';
            }
        }
        unset($product);

        require_once 'app/views/catalog.php';
    }
}
