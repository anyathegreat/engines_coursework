<h1>Пользователи</h1>
<section class="actions-section">
    <div class="section-col">
        <a href="/users/create" class="btn">Создать пользователя</a>
    </div>
    <div class="section-col"></div>
</section>
<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Роль</th>
            <th>Статус</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['enabled'] == 1 ? 'Активен' : 'Отключен'); ?></td>
                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td>
                        <a href="/users/edit?id=<?php echo $user['id']; ?>" class="btn">Редактировать</a>
                        <a href="/users/delete?id=<?php echo $user['id']; ?>" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Нет пользователей.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>