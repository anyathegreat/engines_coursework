<?php
require_once 'app/models/Product.php'; // Не забудьте подключить файл с классом Product
require_once 'app/models/Engine.php'; // Не забудьте подключить файл с классом Engine

class ProductsController
{
  private $productModel;
  private $engineModel;


  public function __construct($db)
  {
    $this->productModel = new Product($db);
    $this->engineModel = new Engine($db);
  }

  public function index()
  {
    // Вызываем метод для получения всех продуктов
    $products = $this->productModel->getAllProducts();
    $engines = $this->engineModel->getAllEngines();

    require_once 'app/views/admin/products/index.php';
  }
}
