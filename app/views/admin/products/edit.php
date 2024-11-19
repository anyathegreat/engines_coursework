<h1>Редактировать товар</h1>
<form id="product-form" enctype="multipart/form-data" action="" method="post">
  <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

  <div class="form-group">
    <label for="article">Артикул:</label>
    <input type="text" name="article" value="<?php echo $product['article']; ?>">
  </div>

  <div class="form-group">
    <label for="name">Название:</label>
    <input type="text" name="name" value="<?php echo $product['name']; ?>">
  </div>

  <div class="form-group">
    <label for="description">Описание:</label>
    <textarea name="description" rows="6"><?php echo htmlspecialchars($product['description']); ?></textarea>
  </div>

  <div class="form-group">
    <label for="price">Цена:</label>
    <input type="number" name="price" min="0" max="999999999" step=".01" value="<?php echo $product['price']; ?>">
  </div>

  <div class="form-group">
    <label for="count">Количество:</label>
    <input type="number" name="count" min="0" max="999999999" value="<?php echo $product['count']; ?>">
  </div>

  <div class="form-group">
    <label for="price">Двигатель:</label>
    <select name="price">
      <option value="">Выбрать двигатель...</option>
      <?php foreach ($engines as $engine): ?>
        <option value="<?php echo $engine['id']; ?>" <?php if ($engine['id'] == $product['engine_id'])
             echo 'selected'; ?>>
          <?php echo $engine['name']; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="avatar">Картинка:</label>
    <div class="preview" style="display: flex; gap: 24px">
      <figure class="prewiew-img">
        <div class="img-container">
          <img id="old-avatar" width="200" height="200"
            src="data:image/jpeg;base64,<?php echo base64_encode($product['img']) ?>" />
        </div>
        <figcaption>Старое изображение</figcaption>
      </figure>
      <figure class="prewiew-img">
        <img id="new-avatar" width="200" height="200" />
        <figcaption>Новое изображение</figcaption>
        <input id="new-avatar-input" type="file" name="img" value="<?php echo $product['name']; ?>" accept="image/*">
      </figure>
    </div>
  </div>

  <div class="form-actions">
    <button type="reset">Сбросить</button>
    <button type="submit">Сохранить</button>
  </div>
</form>
<hr>
<a href="/products" class="btn">Вернуться</a>

<script>
  const newAvatar = document.getElementById('new-avatar');
  const newAvatarInput = document.getElementById('new-avatar-input');
  const form = document.getElementById('product-form');

  function resetAvatar() {
    newAvatar.src = "";
    newAvatarInput.value = "";
    newAvatar.style.visibility = 'hidden';
  }

  newAvatar.style.visibility = 'hidden';

  form.addEventListener('reset', resetAvatar);

  newAvatarInput.addEventListener('change', () => {
    const file = newAvatarInput.files[0];
    if (!file) {
      resetAvatar();
      return;
    }

    const img = new Image();

    img.src = URL.createObjectURL(file);
    img.decode().then(() => {
      const { width, height } = img;
      if (width !== height) {
        alert("Изображение должен быть квадратным");
        resetAvatar();
        return;
      }
      if (width > 512) {
        alert("Размер изображения должен быть не больше 512x512 пикселей");
        resetAvatar();
        return;
      }


      newAvatar.src = URL.createObjectURL(newAvatarInput.files[0]);
      newAvatar.style.visibility = 'visible';
    })

  })
</script>