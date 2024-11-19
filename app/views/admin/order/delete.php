<?php
$title = "Удаление заказа";
$message = "Вы уверены, что хотите удалить заказ с номером " . htmlspecialchars($order['id']) . "?";
$redirect_url_back = "/orders";
$method = "POST";

require_once "app/views/messageConfirm.php";