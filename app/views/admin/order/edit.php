<a href="/order?id=<?php echo $order['id']; ?>" class="btn">Вернуться</a>
<hr>
<h1>Редатирование заказа</h1>
<div>
  <form class="form" action="/order/edit?id=<?php echo $order['id']; ?>" method="post">
    <div class="form-group">
      <label for="status">Статус:</label>
      <select name="status">
        <option value="">Выберите статус</option>
        <?php foreach (ORDER_STATUSES as $key => $status): ?>
          <option value="<?php echo $key; ?>" <?php echo $order['status'] == $key ? 'selected' : ''; ?>>
            <?php echo $status; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>


  </form>
</div>