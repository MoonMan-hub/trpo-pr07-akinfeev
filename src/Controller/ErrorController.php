<?php

// Страницы ошибок.
class ErrorController
{
    private View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    // Страница 404 (неизвестный адрес и маршрут /missing)
    public function notFound(): void
    {
        $this->view->render('errors/404', ['title' => 'Страница не найдена'], 404);
    }

    // Страница 500 (например, сломан pages.json или routes.csv)
    public function serverError(string $message): void
    {
        $this->view->render('errors/500', [
            'title'   => 'Ошибка сервера',
            'message' => $message,
        ], 500);
    }
}
