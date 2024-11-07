<a href="/order?id=<?php echo $orderId; ?>" class="btn">Вернуться</a>
<hr>
<h1>Список товаров в заказе №<?php echo $orderId; ?></h1>
<?php if (isset($errorMessage)): ?>
  <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>
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
    <tbody>
      <?php if (!empty($orderProducts)): ?>
        <?php foreach ($orderProducts as $product): ?>
          <tr>
            <td><?php echo htmlspecialchars($product['product_article']); ?></td>
            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td><?php echo htmlspecialchars($product['product_price']); ?></td>
            <td><input type="number" name="<?php echo $product['product_id']; ?>"
                value="<?php echo htmlspecialchars($product['count']); ?>" min="1" max="999" class="input-product-count">
            </td>
            <td>
              <button type="button" class="btn btn-danger">Удалить</button>
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
  const inputs = document.querySelectorAll('.input-product-count');

  inputs.forEach(input => {
    input.dataset.lastCorrectValue = input.value;

    input.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    input.addEventListener('blur', function () {
      const value = parseInt(input.value, 10);

      if (isNaN(value) || value < 1 || value > 999) {
        input.value = input.dataset.lastCorrectValue;
      } else {
        input.value = value;
        input.dataset.lastCorrectValue = value;
      }
    });
  })
</script>

<script>
  const form = document.getElementById('products-form');

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const inputsArr = [];
    const inputs = document.querySelectorAll('.input-product-count');

    inputs.forEach(input => {
      inputsArr.push({ product_id: input.name, count: input.value });
    });

    const formData = new FormData();

    formData.append('orderId', '<?php echo $orderId; ?>');

    inputsArr.forEach(input => {
      formData.append('productCodes[]', input.product_id + '-' + input.count);
    })

    console.log(Array.from(formData.entries()));

    fetch('/order/edit/products?id=<?php echo $orderId; ?>', {
      method: 'POST',
      body: formData
    }).then(response => {
      if (response.ok) {
        // window.location.href = '/order?id=' + '<?php echo $orderId; ?>';
        console.log(response);
        return response.text();
      }
    }).then(text => {
      document.open();
      document.write(text);
      document.close();
    });
  });
</script>