<section class="box">
    <h1>О магазине</h1>
    <p><b><?= e($storeName) ?></b>. <?= e($tagline) ?>.</p>

    <h2>Чем мы хороши</h2>
    <?php if (count($benefits) === 0): ?>
        <p class="muted">Преимущества пока не указаны.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($benefits as $benefit): ?>
                <li><?= e($benefit) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="/catalog">Посмотреть каталог</a></p>
</section>
