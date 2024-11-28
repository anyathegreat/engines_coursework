<h1><?php echo htmlspecialchars($title); ?></h1>
<p><?php echo htmlspecialchars($message); ?></p>

<form class="form" action="" method="<?php echo $method ?? 'POST'; ?>">
    <?php
    // Извлекаем параметры из текущего URL
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
    foreach ($params as $key => $value) {
        // Создаем скрытое поле для каждого параметра
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    ?>

    <div class="form-actions">
        <a href="<?php echo htmlspecialchars($redirect_url_back); ?>" class="btn">Назад</a>
        <button class="btn btn-danger" type="submit">Подтвердить</button>
    </div>
</form>