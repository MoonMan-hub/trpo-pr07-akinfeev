# Практическая работа №7. PHP MVC интернет-магазин: каркас, маршрутизация и контроллеры

Дисциплина: Технологии разработки программного обеспечения.

## Что сделано

Каркас учебного интернет-магазина по схеме MVC без фреймворка:

- единая точка входа `public/index.php` (без HTML-разметки);
- `Router` читает маршруты из `data/routes.csv` и вызывает нужный контроллер;
- `HomeController`, `CatalogController` и `ErrorController`;
- общий `views/layout.php` (шапка и подвал не копируются по страницам);
- главная страница и «О магазине» берут название, описание и преимущества из `data/pages.json`;
- логотип `public/assets/shop-logo.svg` показывается в шапке и на главной;
- каталог пока показывает тестовые товары (модель будет в следующей работе);
- собственные страницы 404 (HTTP-статус 404) и 500 (если сломан файл данных).

Технологии: PHP 8.0+, HTML, CSS. Библиотеки и composer не нужны.

## Требования

- PHP 8.0 или новее (проверка: `php -v`)

## Запуск

```bash
git clone <ссылка-на-репозиторий>
cd <папка-репозитория>
php -S localhost:8000 -t public public/index.php
```

Открыть в браузере: http://localhost:8000

Важно: корнем сайта должна быть папка `public`, потому что стили и логотип подключаются по адресам `/style.css` и `/assets/shop-logo.svg`.

## Структура

```
.
├── data/
│   ├── routes.csv            обязательный список маршрутов (читает Router)
│   └── pages.json            название магазина, описание, преимущества (читает PageModel)
├── public/
│   ├── index.php             единая точка входа
│   ├── style.css             базовые стили
│   └── assets/shop-logo.svg  логотип из dataset
├── src/
│   ├── Core/
│   │   ├── Router.php        выбор контроллера и действия по пути
│   │   ├── View.php          подключение представления и layout
│   │   └── helpers.php       функция e() для экранирования
│   ├── Controller/
│   │   ├── HomeController.php
│   │   ├── CatalogController.php
│   │   └── ErrorController.php
│   └── Model/
│       └── PageModel.php     чтение pages.json
├── views/
│   ├── layout.php            общая шапка и подвал
│   ├── home/index.php, home/about.php
│   ├── catalog/index.php
│   └── errors/404.php, errors/500.php
├── docs/
│   ├── checklist.md          чек-лист проверки
│   └── defense.md            ответы на вопросы для защиты
├── .gitignore
└── README.md
```

## Маршруты (из routes.csv)

| Метод | Маршрут | Контроллер | Действие | Представление | HTTP |
|-------|---------|------------|----------|---------------|------|
| GET | `/` | HomeController | index | views/home/index.php | 200 |
| GET | `/catalog` | CatalogController | index | views/catalog/index.php | 200 |
| GET | `/about` | HomeController | about | views/home/about.php | 200 |
| GET | `/missing` | ErrorController | notFound | views/errors/404.php | 404 |
| любой другой | любой неизвестный адрес | ErrorController | notFound | views/errors/404.php | 404 |
| (ошибка данных) | сломан `pages.json` или `routes.csv` | ErrorController | serverError | views/errors/500.php | 500 |

## Путь запроса

```
браузер -> public/index.php -> Router -> Controller -> (Model) -> View -> layout.php -> HTML
```

Роли:

- **index.php** создаёт объекты и передаёт их друг другу (зависимости идут через конструкторы), запускает Router.
- **Router** сопоставляет метод и путь с записью из `routes.csv` и вызывает метод контроллера. HTML он не создаёт.
- **Controller** готовит данные и выбирает представление.
- **Model** (`PageModel`) читает и проверяет `pages.json`.
- **View** выводит готовые данные в HTML и ничего не решает про маршруты. Файлы данных view не открывает.

## Конструкторы

- `Router(array $routes, array $controllers)`: получает маршруты и готовые контроллеры.
- `View(string $viewsPath, array $shared)`: получает папку шаблонов и общие данные (название магазина).
- `HomeController(View $view, PageModel $pages)`, `CatalogController(View $view)`, `ErrorController(View $view)`: получают нужные зависимости.
- `PageModel(string $file)`: читает файл и проверяет его при создании.

## Что изменилось по шагам

- Шаг 1-2: структура `public`, `src/Core`, `src/Controller`, `src/Model`, `views`, `data`; dataset скопирован (`routes.csv`, `pages.json` в `data`, логотип в `public/assets`).
- Шаг 3: `public/index.php` стал единой точкой входа, разметки в нём нет.
- Шаг 4, 10, 11: класс `Router`, который получает маршруты и контроллеры через конструктор и не создаёт HTML.
- Шаг 5: `HomeController`, `CatalogController`, `ErrorController` с методами из `routes.csv`.
- Шаг 6, 12: `views/layout.php` и класс `View::render()` с передачей массива данных.
- Шаг 7: главная и «О магазине» выводят название, описание и преимущества из `pages.json`.
- Шаг 8: каталог с тремя тестовыми товарами.
- Шаг 9: страница 404 со статусом 404.
- Шаг 13: базовый CSS.
- Шаг 14: таблица маршрутов выше и чек-лист в `docs/checklist.md`.

## Ограничения

- Маршруты берутся из CSV без параметров в адресе (нет `/product/5`).
- Классы подключаются вручную через `require_once`. При росте проекта нужна автозагрузка (composer, PSR-4, пространства имён).
- Товары в каталоге пока тестовый массив в контроллере.
- Для Apache или Nginx нужно настроить перенаправление всех адресов на `public/index.php`.

## Проверка после чистого клонирования

1. `git clone <ссылка>` и переход в папку проекта
2. `php -S localhost:8000 -t public public/index.php`
3. Пройти сценарии из `docs/checklist.md`
