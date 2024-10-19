<?php
$title = "Удаление товара";
$message = "Вы уверены, что хотите удалить товар с артикулом ".htmlspecialchars($product['article'])."?";
$redirect_url_back = "/products";
$method = "POST";

require_once "app/views/messageConfirm.php";