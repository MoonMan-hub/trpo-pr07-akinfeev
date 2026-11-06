<section>
    <h1>Каталог</h1>
    <p class="muted">Пока показаны тестовые товары. Модель товаров будет добавлена в следующей работе.</p>

    <?php if (count($products) === 0): ?>
        <p class="box muted">Товаров пока нет.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($products as $product): ?>
                <article class="card">
                    <h3><?= e($product['name']) ?></h3>
                    <p class="price"><?= e(number_format($product['price'], 0, ',', ' ')) ?> ₽</p>
                    <p class="muted">id: <?= e($product['id']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
