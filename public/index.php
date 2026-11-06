<?php
// Единая точка входа. Здесь нет разметки: только подключение классов и запуск Router.

// Для встроенного сервера PHP: реальные файлы (css, svg) отдаём как есть
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (is_file($file) && substr($file, -4) !== '.php') {
        return false;
    }
}

define('DATA_DIR', __DIR__ . '/../data');

require_once __DIR__ . '/../src/Core/helpers.php';
require_once __DIR__ . '/../src/Core/View.php';
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Model/PageModel.php';
require_once __DIR__ . '/../src/Controller/HomeController.php';
require_once __DIR__ . '/../src/Controller/CatalogController.php';
require_once __DIR__ . '/../src/Controller/ErrorController.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = Router::normalizePath($_SERVER['REQUEST_URI'] ?? '/');

// Общие данные для всех страниц (запасное название на случай ошибки в pages.json)
$view = new View(__DIR__ . '/../views', [
    'storeName'   => 'Интернет-магазин',
    'currentPath' => $path,
]);
$errorController = new ErrorController($view);

try {
    $pages = new PageModel(DATA_DIR . '/pages.json');
    $view->share('storeName', $pages->getStoreName());

    $controllers = [
        'HomeController'    => new HomeController($view, $pages),
        'CatalogController' => new CatalogController($view),
        'ErrorController'   => $errorController,
    ];

    $router = new Router(Router::readCsv(DATA_DIR . '/routes.csv'), $controllers);
    $router->dispatch($method, $path);
} catch (RuntimeException $e) {
    $errorController->serverError($e->getMessage());
}
