<?php

// Представление: подключает файл из папки views внутри общего layout.
// Решений о маршрутах View не принимает, только выводит готовые данные.
class View
{
    private string $viewsPath;
    private array $shared;

    // $viewsPath - папка с шаблонами, $shared - данные для всех страниц (например, название магазина)
    public function __construct(string $viewsPath, array $shared = [])
    {
        $this->viewsPath = $viewsPath;
        $this->shared = $shared;
    }

    // Добавляет общее значение для всех страниц
    public function share(string $key, $value): void
    {
        $this->shared[$key] = $value;
    }

    // Выводит страницу: сначала шаблон страницы, потом он вставляется в layout.php.
    // $template - путь внутри views без .php, $data - массив с данными, $status - HTTP-код
    public function render(string $template, array $data = [], int $status = 200): void
    {
        $file = $this->viewsPath . '/' . $template . '.php';
        $layout = $this->viewsPath . '/layout.php';

        if (!file_exists($file) || !file_exists($layout)) {
            throw new RuntimeException('Не найден файл представления: ' . $template);
        }

        http_response_code($status);

        // ключи массивов становятся переменными в шаблоне
        extract($this->shared);
        extract($data);

        ob_start();
        require $file;
        $content = ob_get_clean();

        require $layout;
    }
}
