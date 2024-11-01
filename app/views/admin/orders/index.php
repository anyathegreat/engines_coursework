<h1>Заказы</h1>
<table>
  <thead>
    <tr>
      <th>Дата создания</th>
      <th>Дата обновления</th>
      <th>Статус заказа</th>
      <th>Покупатель</th>
      <th>Почта</th>
      <th>Телефон</th>
      <th>Цена</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($orders)): ?>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td><?php echo htmlspecialchars($order['date_created']); ?></td>
          <td><?php echo htmlspecialchars($order['date_updated']); ?></td>
          <td><?php echo htmlspecialchars($order['status']); ?></td>
          <td><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?></td>
          <td><?php echo htmlspecialchars($order['email']); ?></td>
          <td><?php echo htmlspecialchars($order['phone']); ?></td>
          <td><?php echo htmlspecialchars($order['price'] ?? 0); ?></td>
          <td>
            <a href="/order?id=<?php echo $order['order_id']; ?>" class="btn">Открыть</a>
            <a href="/order/delete?id=<?php echo $order['order_id']; ?>" class="btn btn-danger">Удалить</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="8">Нет заказов.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>