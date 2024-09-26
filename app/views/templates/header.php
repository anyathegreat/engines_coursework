<?php
$links = [
    ["/users", "Пользователи", ["admin"]],
    ["/orders", "Заказы", []],
    ["/catalog", "Каталог", ["anonymous"]],
    ["/login", "Админ-панель", ["anonymous"]],
];
?>
<header>
    <nav>
        <div class="menu">
            <!-- <a class="menu-item" href="/catalog">Каталог</a>
            <a class="menu-item" href="/login">Админ-панель</a>
            <a class="menu-item" href="/users">Пользователи</a>
            <a class="menu-item" href="/orders">Заказы</a> -->
            <?php foreach ($links as $link): ?>
                <?php if (in_array("anonymous", $link[2]) || isset($_SESSION['user_email'])): ?>
                    <?php if (empty($link[2]) || in_array("anonymous", $link[2]) || in_array($_SESSION['user_role'], $link[2])): ?>
                        <a class="menu-item" href="<?php echo $link[0]; ?>">
                            <?php echo $link[1]; ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </nav>

    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['user_email'])) {
        echo '<a class="logout-btn" href="/logout">Выйти</a>';
    }
    ?>
</header>