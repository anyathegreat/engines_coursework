<a href="/order?id=<?php echo $orderId; ?>" class="btn">Вернуться</a>
<hr>
<h1>Список товаров в заказе №<?php echo $orderId; ?></h1>
<?php if (isset($errorMessage)): ?>
  <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>
<select name="" id="product-select">
  <option value="">Выберите товар...</option>
  <?php foreach ($allProductsMin as $product): ?>
    <option value='<?php echo json_encode($product); ?>'>
      <?php echo $product['article'] . ' - ' . $product['name']; ?>
    </option>
  <?php endforeach; ?>
</select>
<button type="button" id="btn-add-product" class="btn">Добавить</button>
<br>
<br>
<form action="/order/editProducts?id=<?php echo $orderId; ?>" method="post" id="products-form">
  <table>
    <thead>
      <tr>
        <th>Артикул</th>
        <th>Название</th>
        <th>Цена (руб.)</th>
        <th>Количество</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody id="product-list">
      <?php if (!empty($orderProducts)): ?>
        <?php foreach ($orderProducts as $product): ?>
          <tr class="product-row" data-product-id="<?php echo $product['product_id']; ?>">
            <td><?php echo htmlspecialchars($product['product_article']); ?></td>
            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td><?php echo htmlspecialchars($product['product_price']); ?></td>
            <td>
              <div>
                <input type="number" value="<?php echo htmlspecialchars($product['count']); ?>" min="1" max="999"
                  class="input-product-count">
              </div>
              <div style="height: 1rem; margin-top: -0.375rem;">
                <span style="font-size: 0.625rem;">(на складе:
                  <?php echo htmlspecialchars($product['product_count']); ?>)
                </span>
              </div>
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-delete-product">Удалить</button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">Нет товаров.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <button type="reset" class="btn btn-danger">Сбросить</button>
  <button type="submit" class="btn">Сохранить</button>
</form>

<script>
  // Initialize Select2
  $(document).ready(function () {
    $('#product-select').select2();
    $('#btn-add-product').on('click', function () {
      const selectedProduct = $('#product-select').val();

      if (!selectedProduct) {
        return;
      }

      const product = JSON.parse($('#product-select').val());
      let hasDuplicate = false;
      const rowHtml = `
          <tr class="product-row" data-product-id="${product.id}">
            <td>${product.article}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>
              <div>
                <input type="number" value="1" min="1" max="999" class="input-product-count">
              </div>
              <div style="height: 1rem; margin-top: -0.375rem;">
                <span style="font-size: 0.625rem;">
                  (на складе: ${product.count})
                </span>
              </div>
            </td>
            <td class="actions-td"></td>
          </tr>
        `;
      $('#product-list .product-row').each(function () {
        const productId = this.dataset.productId; // Получаем значение productId

        if (product.id === productId) {
          hasDuplicate = true;
        }
      });

      if (product) {
        if (!hasDuplicate) {
          const row = $(rowHtml);
          const deleteButton = $(`<button class="btn btn-danger btn-delete-product">Удалить</button>`);

          deleteButton.on("click", function () {
            row.remove();
          });

          row.find(".actions-td")?.append(deleteButton);

          $('#product-list').append(row);
        } else {
          alert('Товар уже добавлен в заказ.');
        }
      }
    });
  });
</script>

<script>
  // Input validation
  const inputs = document.querySelectorAll('.input-product-count');

  inputs.forEach(input => {
    input.dataset.lastCorrectValue = input.value;

    input.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    input.addEventListener('blur', function () {
      const value = parseInt(input.value, 10);

      if (isNaN(value) || value < 1 || value > 999) {
        input.value = input.dataset.lastCorrectValue || 1;
      } else {
        input.value = value;
        input.dataset.lastCorrectValue = value;
      }
    });
  })
</script>

<script>
  // Delete product
  const rows = document.querySelectorAll('.product-row');

  rows.forEach(row => {
    const deleteButton = row.querySelector('.btn-delete-product');
    deleteButton.addEventListener('click', function () {
      row.remove();
    })
  });
</script>

<script>
  // Form submit
  const form = document.getElementById('products-form');

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData();
    const rows = document.querySelectorAll('.product-row');

    formData.append('orderId', '<?php echo $orderId; ?>');

    rows.forEach(row => {
      const input = row.querySelector('.input-product-count');
      formData.append('productCodes[]', row.dataset.productId + '-' + input.value);
    });

    fetch('/order/edit/products?id=<?php echo $orderId; ?>', {
      method: 'POST',
      body: formData
    }).then(response => {
      if (response.ok) {
        // window.location.href = '/order?id=' + '<?php echo $orderId; ?>';
        return response.text();
      }
    }).then(text => {
      document.open();
      document.write(text);
      document.close();
    });
  });
</script>