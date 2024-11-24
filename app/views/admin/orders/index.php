<h1>Заказы</h1>

<h3>Фильтры</h3>

<form class="form-filters" action="">

  <div class="filters-container">
    <input type="text" name="page" value="<?php echo $ordersObj['currentPage']; ?>" hidden>
    <div class="filters-row">
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Почта:</label>
          <input type="text" name="email" value="<?php echo $filters['email']; ?>">
        </div>
      </div>
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Телефон:</label>
          <input type="text" name="phone" value="<?php echo $filters['phone']; ?>">
        </div>
      </div>
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Статус заказа:</label>
          <select name="status">
            <option value="">Все</option>
            <?php foreach (ORDER_STATUSES as $key => $status): ?>
              <option value="<?php echo $key; ?>" <?php echo $filters['status'] == $key ? 'selected' : ''; ?>>
                <?php echo $status; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

      </div>
    </div>
    <div class="filters-row">
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Имя:</label>
          <input type="text" name="firstname" value="<?php echo $filters['firstname']; ?>">
        </div>
      </div>
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Фамилия:</label>
          <input type="text" name="lastname" value="<?php echo $filters['lastname']; ?>">
        </div>
      </div>
      <div class="filters-col"></div>
    </div>
    <div class="filters-row">
      <div class="filters-col">
        <div class="filters-group">
          <label for="status">Дата от:</label>
          <input type="date" name="dateFrom" value="<?php echo $filters['dateFrom']; ?>">
        </div>
        <div class="filters-group">
          <label for="status">Дата до:</label>
          <input type="date" name="dateTo" value="<?php echo $filters['dateTo']; ?>">
        </div>
      </div>
      <div class="filters-col"></div>
      <div class="filters-col"></div>
    </div>

    <div class="filters-actions">
      <button type="submit" id="clear-filters-btn" class="btn btn-danger">Очистить</button>
      <button type="submit" class="btn">Найти</button>
    </div>
  </div>



  <h3>
    Найдено заказов: <?php echo htmlspecialchars($ordersObj['totalResults']); ?>
    <span
      style="font-size: 0.750rem;">(<?php echo htmlspecialchars($ordersObj['totalPages']) . ' ' . getNumeralString($ordersObj['totalPages'], ['страница', 'страницы', 'страниц']); ?>)</span>
  </h3>
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
        <button data-page="1" class="pagination-btn">&lt;&lt;</button>
      <?php } ?>

      <?php if ($ordersObj['currentPage'] <= 1) { ?>
        <span class="pagination-btn pagination-disabled">&lt;</span>
      <?php } else { ?>
        <button data-page="<?php echo max(1, $ordersObj['currentPage'] - 1) ?>" class="pagination-btn">&lt;</button>
      <?php } ?>

      <div class="pagination-divider"></div>

      <?php foreach ($pageIndexes as $pageIndex): ?>
        <?php if ($pageIndex == $ordersObj['currentPage']): ?>
          <span class="pagination-btn pagination-active"><?php echo $pageIndex; ?></span>
        <?php endif; ?>
        <?php if ($pageIndex != $ordersObj['currentPage']): ?>
          <button data-page="<?php echo $pageIndex; ?>" class="pagination-btn"><?php echo $pageIndex; ?></button>
        <?php endif; ?>
      <?php endforeach; ?>

      <div class="pagination-divider"></div>

      <?php if ($ordersObj['currentPage'] >= $ordersObj['totalPages']) { ?>
        <span class="pagination-btn pagination-disabled">&gt;</span>
      <?php } else { ?>
        <button data-page="<?php echo min($ordersObj['totalPages'], $ordersObj['currentPage'] + 1) ?>"
          class="pagination-btn">&gt;</button>
      <?php } ?>

      <?php if ($ordersObj['currentPage'] >= $ordersObj['totalPages']) { ?>
        <span class="pagination-btn pagination-disabled">&gt;&gt;</span>
      <?php } else { ?>
        <button data-page="<?php echo $ordersObj['totalPages']; ?>" class="pagination-btn">&gt;&gt;</button>
      <?php } ?>
    </div>
    <div class="pagination-input-container">
      <input type="text" value="<?php echo $ordersObj['currentPage']; ?>"
        data-page="<?php echo $ordersObj['currentPage']; ?>" min="1" max="<?php echo $ordersObj['totalPages']; ?>"
        class="pagination-input">
      <button type="submit" class="btn">Перейти</button>
    </div>
    <div style="height: 1rem; margin-top: -0.375rem;">
      <span style="font-size: 0.625rem;">1 – <?php echo $ordersObj['totalPages']; ?></span>
    </div>
  </div>
</form>

<script>
  // Input validation
  const input = document.querySelector('.pagination-input');

  input.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  input.addEventListener('blur', function () {
    const value = parseInt(input.value, 10);

    if (isNaN(value) || value < 1 || value > <?php echo $ordersObj['totalPages']; ?>) {
      input.value = input.dataset.page || <?php echo $ordersObj['currentPage']; ?>;
    } else {
      input.value = value;
      input.dataset.page = value;
    }
  });
</script>

<script>
  // const btn = document.querySelector('.pagination-input-container button');

  // btn.addEventListener('click', function () {
  //   window.location.href = '/orders?page=' + input.value;
  // });
</script>

<script>
  const form = document.querySelector('.form-filters');
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    const submitter = event.submitter;
    const toPage = submitter.dataset.page || "1";

    if (submitter.id === "clear-filters-btn") {
      window.location.href = "/orders?page=1";
      return;
    }

    let url = "/orders";
    url += "?page=" + toPage;

    if (form.dateFrom.value?.trim()) {
      url += "&dateFrom=" + encodeURIComponent(form.dateFrom.value?.trim());
    }

    if (form.dateTo.value?.trim()) {
      url += "&dateTo=" + encodeURIComponent(form.dateTo.value?.trim());
    }

    if (form.status.value?.trim()) {
      url += "&status=" + encodeURIComponent(form.status.value?.trim());
    }

    if (form.email.value?.trim()) {
      url += "&email=" + encodeURIComponent(form.email.value?.trim());
    }

    if (form.phone.value?.trim()) {
      url += "&phone=" + encodeURIComponent(form.phone.value?.trim()?.replace(/[^0-9]/g, ''));
    }

    if (form.firstname.value?.trim()) {
      url += "&firstname=" + encodeURIComponent(form.firstname.value?.trim());
    }

    if (form.lastname.value?.trim()) {
      url += "&lastname=" + encodeURIComponent(form.lastname.value?.trim());
    }

    window.location.href = url;
  })
</script>