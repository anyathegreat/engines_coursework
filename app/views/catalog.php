<h1>Каталог</h1>
<table>
    <thead>
        <tr>
            <th>Картинка</th>
            <th>Артикул</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>В наличии</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img alt="Типа деталька" width="100" height="100"
                            src="<?php echo htmlspecialchars($product['img']) ?>" /></td>
                    <td><?php echo htmlspecialchars($product['article']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?>руб.</td>
                    <td><?php echo htmlspecialchars($product['count']); ?></td>
                    <td><button>Добавить в заказ</button></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Нет доступных продуктов.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>