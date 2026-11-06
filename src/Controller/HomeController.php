<?php

// Главная страница и страница "О магазине".
// Контроллер готовит данные и выбирает представление.
class HomeController
{
    private View $view;
    private PageModel $pages;

    public function __construct(View $view, PageModel $pages)
    {
        $this->view = $view;
        $this->pages = $pages;
    }

    // GET /
    public function index(): void
    {
        $this->view->render('home/index', [
            'title'    => 'Главная',
            'tagline'  => $this->pages->getTagline(),
            'benefits' => $this->pages->getBenefits(),
        ]);
    }

    // GET /about
    public function about(): void
    {
        $this->view->render('home/about', [
            'title'    => 'О магазине',
            'tagline'  => $this->pages->getTagline(),
            'benefits' => $this->pages->getBenefits(),
        ]);
    }
}
