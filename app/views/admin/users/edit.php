<h1>Редактировать пользователя</h1>
<form action="" method="post">
  <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

  <div class="form-group">
    <label for="email">E-mail:</label>
    <input type="email" name="email" placeholder="example@mail.com" value="<?php echo $user['email']; ?>">
  </div>

  <div class="form-group">
    <label for="role">Роль:</label>
    <select name="role">
      <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>Пользователь</option>
      <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Администратор</option>
    </select>
  </div>

  <div class="form-group">
    <label for="firstname">Имя:</label>
    <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>">
  </div>

  <div class="form-group">
    <label for="lastname">Фамилия:</label>
    <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>">
  </div>

  <div class="form-group">
    <label for="phone">Телефон:</label>
    <input type="text" name="phone" placeholder="+7 (999) 999-99-99" value="<?php echo $user['phone']; ?>">
  </div>

  <div class="form-actions">
    <button type="reset">Сбросить</button>
    <button type="submit">Сохранить</button>
  </div>
</form>
<hr>
<a href="/users" class="btn">Вернуться</a>