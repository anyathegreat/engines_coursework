<h1>Заказы</h1>
<h3>Найдено заказов: <?php echo htmlspecialchars($ordersObj['totalResults']); ?></h3>
<h3>Страниц: <?php echo htmlspecialchars($ordersObj['totalPages']); ?> </h3>
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
      <th>Продукты</th>
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
            <?php foreach ($order['products'] as $product): ?>
              <div><?php echo htmlspecialchars($product['product_name']); ?></div>
            <?php endforeach; ?>
          </td>
          <td>
            <a href="/order?id=<?php echo $order['order_id']; ?>" class="btn">Открыть</a>
            <a href="/order/delete?id=<?php echo $order['order_id']; ?>" class="btn btn-danger">Удалить</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="9">Нет заказов.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
<div>
  <div class="pagination">
    <?php if ($ordersObj['currentPage'] <= 1) { ?>
      <span class="pagination-btn pagination-disabled">&lt;&lt;</span>
    <?php } else { ?>
      <a href="/orders?page=1" class="pagination-btn">&lt;&lt;</a>
    <?php } ?>

    <?php if ($ordersObj['currentPage'] <= 1) { ?>
      <span class="pagination-btn pagination-disabled">&lt;</span>
    <?php } else { ?>
      <a href="/orders?page=<?php echo max(1, $ordersObj['currentPage'] - 1) ?>" class="pagination-btn">&lt;</a>
    <?php } ?>

    <div class="pagination-divider"></div>

    <?php foreach ($pageIndexes as $pageIndex): ?>
      <?php if ($pageIndex == $ordersObj['currentPage']): ?>
        <span class="pagination-btn pagination-active"><?php echo $pageIndex; ?></span>
      <?php endif; ?>
      <?php if ($pageIndex != $ordersObj['currentPage']): ?>
        <a href="/orders?page=<?php echo $pageIndex; ?>" class="pagination-btn"><?php echo $pageIndex; ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <div class="pagination-divider"></div>

    <?php if ($ordersObj['currentPage'] >= $ordersObj['totalPages']) { ?>
      <span class="pagination-btn pagination-disabled">&gt;</span>
    <?php } else { ?>
      <a href="/orders?page=<?php echo min($ordersObj['totalPages'], $ordersObj['currentPage'] + 1) ?>"
        class="pagination-btn">&gt;</a>
    <?php } ?>

    <?php if ($ordersObj['currentPage'] >= $ordersObj['totalPages']) { ?>
      <span class="pagination-btn pagination-disabled">&gt;&gt;</span>
    <?php } else { ?>
      <a href="/orders?page=<?php echo $ordersObj['totalPages']; ?>" class="pagination-btn">&gt;&gt;</a>
    <?php } ?>
  </div>
  <div class="pagination-input-container">
    <input type="text" value="<?php echo $ordersObj['currentPage']; ?>" min="1"
      max="<?php echo $ordersObj['totalPages']; ?>" class="pagination-input">
    <button type="button" class="btn">Перейти</button>
  </div>
  <div style="height: 1rem; margin-top: -0.375rem;">
    <span style="font-size: 0.625rem;">1 – <?php echo $ordersObj['totalPages']; ?></span>
  </div>
</div>

<script>
  // Input validation
  const input = document.querySelector('.pagination-input');

  input.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  input.addEventListener('blur', function () {
    const value = parseInt(input.value, 10);

    if (isNaN(value) || value < 1 || value > <?php echo $ordersObj['totalPages']; ?>) {
      input.value = input.dataset.lastCorrectValue || <?php echo $ordersObj['currentPage']; ?>;
    } else {
      input.value = value;
      input.dataset.lastCorrectValue = value;
    }
  });
</script>

<script>
  const btn = document.querySelector('.pagination-input-container button');

  btn.addEventListener('click', function () {
    window.location.href = '/orders?page=' + input.value;
  });
</script>