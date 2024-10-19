<h1>Товары</h1>
<section class="actions-section">
  <div class="section-col">
    <a href="/products/create" class="btn">Создать товар</a>
  </div>
  <div class="section-col"></div>
</section>
<table>
  <thead>
    <tr>
      <th>Артикул</th>
      <th>Название</th>
      <th>Цена (руб.)</th>
      <th>Количество</th>
      <th>Двигатель</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <tr>
          <td><?php echo htmlspecialchars($product['article']); ?></td>
          <td><?php echo htmlspecialchars($product['name']); ?></td>
          <td><?php echo htmlspecialchars($product['price']); ?></td>
          <td><?php echo htmlspecialchars($product['count']); ?></td>
          <td><?php echo htmlspecialchars(getEngineName($product['engine_id'], $engines)); ?></td>
          <td>
            <a href="/products/edit?id=<?php echo $product['id']; ?>" class="btn">Редактировать</a>
            <a href="/products/delete?id=<?php echo $product['id']; ?>" class="btn btn-danger">Удалить</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">Нет товаров.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>