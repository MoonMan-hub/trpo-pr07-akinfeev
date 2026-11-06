<?php

// Модель данных страниц магазина. Читает data/pages.json.
class PageModel
{
    private string $storeName;
    private string $tagline;
    private array $benefits = [];

    // Читает и проверяет файл сразу при создании объекта
    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new RuntimeException('Файл не найден: ' . basename($file));
        }

        $raw = @file_get_contents($file);
        if ($raw === false) {
            throw new RuntimeException('Не удалось прочитать файл: ' . basename($file));
        }

        try {
            $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Файл повреждён (неверный JSON): ' . basename($file));
        }

        if (!is_array($data) || !isset($data['store_name'], $data['tagline'])) {
            throw new RuntimeException('В файле ' . basename($file) . ' нет полей store_name или tagline');
        }

        $this->storeName = (string)$data['store_name'];
        $this->tagline = (string)$data['tagline'];

        // преимущества необязательны: если их нет, список останется пустым
        if (isset($data['benefits']) && is_array($data['benefits'])) {
            foreach ($data['benefits'] as $benefit) {
                if (is_string($benefit) && trim($benefit) !== '') {
                    $this->benefits[] = trim($benefit);
                }
            }
        }
    }

    public function getStoreName(): string
    {
        return $this->storeName;
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }

    public function getBenefits(): array
    {
        return $this->benefits;
    }
}
