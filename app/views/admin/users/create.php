<h1>Создание нового пользователя</h1>
<?php if (isset($errorMessage)): ?>
  <p style="color:red;"><?php echo htmlspecialchars($errorMessage); ?></p>
<?php endif; ?>

<form action="" method="POST">
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" required>
  </div>

  <div class="form-group">
    <label for="password">Пароль:</label>
    <input type="password" name="password" required>
  </div>

  <div class="form-group">
    <label for="password_confirm">Повторите пароль:</label>
    <input type="password" name="password_confirm" required>
  </div>

  <div class="form-group">
    <label for="role">Роль:</label>
    <select name="role">
      <option value="user">Пользователь</option>
      <option value="admin">Администратор</option>
    </select>
  </div>

  <div class="form-group">
    <label for="firstname">Имя:</label>
    <input type="text" name="firstname">
  </div>

  <div class="form-group">
    <label for="lastname">Фамилия:</label>
    <input type="text" name="lastname">
  </div>

  <div class="form-group">
    <label for="phone">Телефон:</label>
    <input type="text" name="phone">
  </div>

  <div class="form-actions">
    <button type="reset">Очистить</button>
    <button type="submit">Создать пользователя</button>
  </div>
</form>
<hr>
<a href="/users" class="btn">Вернуться</a>