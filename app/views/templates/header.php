<header>
    <nav>
        <div class="menu">
            <a class="menu-item" href="/catalog">Каталог</a>
            <a class="menu-item" href="/login">Админ-панель</a>
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