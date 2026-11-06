<section class="hero">
    <div>
        <span class="pill">интернет-магазин</span>
        <h1><?= e($storeName) ?></h1>
        <p class="lead"><?= e($tagline) ?></p>
        <a href="/catalog" class="btn">Перейти в каталог</a>
    </div>
    <img src="/assets/shop-logo.svg" alt="Иллюстрация магазина" class="hero-img">
</section>

<section id="benefits">
    <h2>Преимущества</h2>
    <?php if (count($benefits) === 0): ?>
        <p class="box muted">Преимущества пока не указаны.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($benefits as $benefit): ?>
                <article class="card"><?= e($benefit) ?></article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
