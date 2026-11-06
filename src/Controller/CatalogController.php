<?php

// Каталог товаров.
class CatalogController
{
    private View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    // GET /catalog
    public function index(): void
    {
        // Пока тестовые данные. Полноценная модель товаров будет в следующей работе.
        $products = [
            ['id' => 1, 'name' => 'Тетрадь в клетку', 'price' => 45],
            ['id' => 2, 'name' => 'Набор ручек', 'price' => 190],
            ['id' => 3, 'name' => 'Школьный рюкзак', 'price' => 1250],
        ];

        $this->view->render('catalog/index', [
            'title'    => 'Каталог',
            'products' => $products,
        ]);
    }
}
