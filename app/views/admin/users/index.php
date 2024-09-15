<h1>Пользователи</h1>
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
                    <td><?php echo htmlspecialchars($user['enabled']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><a href="/users/edit?id=<?php echo $user['id']; ?>">Редактировать</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Нет пользователей.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>