<h1>Редактировать пользователя</h1>
<form action="" method="post">
  <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
  <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
  <input type="text" name="firstname" placeholder="Имя" value="<?php echo $user['firstname']; ?>">
  <input type="text" name="lastname" placeholder="Фамилия" value="<?php echo $user['lastname']; ?>">
  <input type="text" name="phone" placeholder="Телефон" value="<?php echo $user['phone']; ?>">
  <button type="submit">Сохранить</button>
</form>
<a href="/users">Вернуться</a>