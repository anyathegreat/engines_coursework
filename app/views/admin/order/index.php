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
</div>