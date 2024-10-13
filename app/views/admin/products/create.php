<h1>Создание нового пользователя</h1>
<?php if (isset($errorMessage)): ?>
  <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<form action="" method="POST">
  <div class="form-group">
    <label for="article">Артикул:</label>
    <input type="text" name="article" required>
  </div>

  <div class="form-group">
    <label for="name">Название:</label>
    <input type="text" name="name" required>
  </div>

  <div class="form-group">
    <label for="price">Повторите пароль:</label>
    <input type="number" name="price" required>
  </div>

  <div class="form-group">
    <label for="count">Количество:</label>
    <input type="number" name="count">
  </div>

  <div class="form-group">
    <label for="engine_id">Двигатель:</label>
    <select name="engine_id">
      <option value=""></option>
      <option value=""></option>
      <option value=""></option>
      <option value=""></option>
    </select>
  </div>
</form>
<hr>
<a href="/users" class="btn">Вернуться</a>