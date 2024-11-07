<a href="/orders" class="btn">Вернуться</a>
<a href="/order/edit?id=<?php echo $order['id']; ?>" class="btn">Редактировать</a>
<a href="/order/edit/products?id=<?php echo $order['id']; ?>" class="btn">Список товаров</a>
<hr>
<h1>Детали заказа</h1>
<div>
  <div>
    <span>Номер заказа</span>: <span><?php echo $order['id']; ?></span>
  </div>
  <div>
    <span>Ид. покупателя</span>: <span><?php echo $order['customerID']; ?></span>
  </div>
  <div>
    <span>Дата создания заказа</span>: <span><?php echo $order['date_created']; ?></span>
  </div>
  <div>
    <span>Дата обновления заказа</span>: <span><?php echo $order['date_updated']; ?></span>
  </div>
  <div>
    <span>Статус</span>: <span><?php echo $order['status']; ?></span>
  </div>
  <div>
    <span>Телефон</span>: <span><?php echo $customer['phone']; ?></span>
  </div>
  <div>
    <span>Общая стоимость</span>: <span><?php echo $order['price']; ?></span>
  </div>
</div>
<div>
  <h2>Товары в заказе</h2>
  <div>
    <?php foreach ($products as $product): ?>
      <div>
        <span>Название</span>: <span><?php echo $product['product_name']; ?></span>
      </div>
      <div>
        <span>Артикул</span>: <span><?php echo $product['product_article']; ?></span>
      </div>
      <div>
        <span>Количество</span>: <span><?php echo $product['count_in_order']; ?></span>
      </div>
      <div>
        <span>Цена</span>: <span><?php echo $product['product_price']; ?></span>
      </div>
      <br>
    <?php endforeach; ?>
  </div>
</div>