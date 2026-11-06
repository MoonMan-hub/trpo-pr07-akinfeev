<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Страница') ?> | <?= e($storeName) ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<header class="header">
    <a href="/" class="logo">
        <img src="/assets/shop-logo.svg" alt="Логотип магазина" height="40">
        <span><?= e($storeName) ?></span>
    </a>
    <nav class="nav">
        <a href="/" class="<?= $currentPath === '/' ? 'active' : '' ?>">Главная</a>
        <a href="/catalog" class="<?= $currentPath === '/catalog' ? 'active' : '' ?>">Каталог</a>
        <a href="/about" class="<?= $currentPath === '/about' ? 'active' : '' ?>">О магазине</a>
    </nav>
</header>

<main class="wrap">
    <?= $content ?>
</main>

<footer class="footer">
    <p class="muted"><?= e($storeName) ?>. Практическая работа №7, технологии разработки программного обеспечения.</p>
</footer>
</body>
</html>
