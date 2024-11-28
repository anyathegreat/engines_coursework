<h1>Создание нового товар</h1>
<?php if (isset($errorMessage)): ?>
  <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<form class="form" id="product-form" enctype="multipart/form-data" action="" method="post">
  <div class="form-group">
    <label for="article">Артикул:</label>
    <input required type="text" name="article" value="">
  </div>

  <div class="form-group">
    <label for="name">Название:</label>
    <input required type="text" name="name" value="">
  </div>

  <div class="form-group">
    <label for="description">Описание: <span class="field-extra-label">(необязательно)</span></label>
    <textarea name="description" rows="6"></textarea>
  </div>

  <div class="form-group">
    <label for="price">Цена:</label>
    <input required type="number" name="price" min="0" max="999999999" step=".01" value="0">
  </div>

  <div class="form-group">
    <label for="price">Двигатель: <span class="field-extra-label">(необязательно)</span></label>
    <select name="engine_id">
      <option value="">Выбрать двигатель...</option>
      <?php foreach ($engines as $engine): ?>
        <option value="<?php echo $engine['id']; ?>">
          <?php echo $engine['name']; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="avatar">Картинка: <span class="field-extra-label">(необязательно)</span></label>
    <div class="preview" style="display: flex; gap: 24px">
      <figure class="prewiew-img">
        <div class="img-container">
          <img id="new-avatar" width="200" height="200" />
        </div>
        <figcaption>Новое изображение</figcaption>
        <input id="new-avatar-input" type="file" name="img" value="<?php echo $product['name']; ?>" accept="image/*">
      </figure>
    </div>
  </div>

  <div class="form-actions">
    <button type="reset">Сбросить</button>
    <button type="submit">Создать</button>
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