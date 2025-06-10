<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Starting AttributeSeeder ---');

        $attributes = [
            // Общие атрибуты
            ['slug' => 'screen_size', 'name' => 'Диагональ экрана', 'type' => 'decimal', 'unit' => '"', 'options' => [13.3, 14.0, 15.6, 16.0, 17.3, 23.8, 27.0, 31.5, 32.0, 34.0, 43.0, 50.0, 55.0, 65.0, 75.0, 11.0, 14.6, 12.7, 13.0, 12.4, 10.9, 6.8, 6.7, 6.36, 6.6, 6.78, 6.1, 6.67]],
            ['slug' => 'color', 'name' => 'Цвет', 'type' => 'multiselect', 'options' => ['Черный', 'Белый', 'Серый', 'Серебристый', 'Красный', 'Синий', 'Зеленый', 'Золотой', 'Розовый', 'Серый космос', 'Бирюзовый', 'Темно-синий', 'Титановый Серый', 'Натуральный титан', 'Голубой', 'Черно-красный', 'Мятный', 'Графит', 'Темно-серый']],
            ['slug' => 'warranty', 'name' => 'Гарантия', 'type' => 'integer', 'unit' => 'мес.', 'options' => [12, 24, 36]],
            ['slug' => 'touchscreen', 'name' => 'Сенсорный экран', 'type' => 'boolean'],

            // Атрибуты экрана
            ['slug' => 'refresh_rate', 'name' => 'Частота обновления', 'type' => 'integer', 'unit' => 'Гц', 'options' => [60, 75, 90, 120, 144, 165, 240, 360]],
            ['slug' => 'resolution', 'name' => 'Разрешение экрана', 'type' => 'multiselect', 'options' => ['1366x768 (HD)', '1920x1080 (FHD)', '2560x1440 (QHD)', '3840x2160 (4K UHD)', '2560x1600 (WQXGA)', '2560x1664', '3456x2160', '2880x1800', '1920x1200', '3840x2400', '3120x1440', '2796x1290', '2992x1344', '2670x1200', '2340x1080', '2400x1080', '2556x1179', '2712x1220', '3440x1440', '2420x1668', '2960x1848', '2944x1840', '2732x2048', '2360x1640']],
            ['slug' => 'matrix_type', 'name' => 'Тип матрицы', 'type' => 'multiselect', 'options' => ['IPS', 'OLED', 'TN', 'VA', 'PLS', 'AHVA', 'Mini-LED', 'Nano IPS', 'IPS Black', 'Rapid IPS', 'Dynamic AMOLED 2X', 'Super Retina XDR', 'AMOLED', 'Super AMOLED', 'Neo QLED', 'QLED', 'LED', 'QD-OLED']],
            ['slug' => 'response_time', 'name' => 'Время отклика', 'type' => 'integer', 'unit' => 'мс', 'options' => [1, 2, 4, 5, 8]],
            ['slug' => 'aspect_ratio', 'name' => 'Соотношение сторон', 'type' => 'multiselect', 'options' => ['16:9', '16:10', '21:9', '32:9']],
            ['slug' => 'hdr_support', 'name' => 'Поддержка HDR', 'type' => 'multiselect', 'options' => ['DisplayHDR 400', 'DisplayHDR 600', 'DisplayHDR 1000', 'Есть', 'Нет']],

            // Атрибуты производительности
            ['slug' => 'ram_size', 'name' => 'Объем ОЗУ', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [4, 6, 8, 12, 16, 24, 32, 64]],
            ['slug' => 'ram_type', 'name' => 'Тип ОЗУ', 'type' => 'multiselect', 'options' => ['DDR3', 'DDR4', 'DDR5', 'LPDDR3', 'LPDDR4X', 'LPDDR5', 'LPDDR5X', 'Unified']],
            ['slug' => 'cpu_series', 'name' => 'Серия процессора', 'type' => 'multiselect', 'options' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'Intel Pentium', 'Intel Celeron', 'AMD Ryzen 3', 'AMD Ryzen 5', 'AMD Ryzen 7', 'AMD Ryzen 9', 'AMD Athlon', 'Apple M1', 'Apple M2', 'Apple M3', 'Apple M4', 'Intel Core Ultra 5', 'Intel Core Ultra 7', 'Snapdragon 8 Gen 3', 'A17 Pro', 'Google Tensor G3', 'Exynos 1480', 'MediaTek Dimensity 7200 Ultra', 'A16 Bionic', 'Snapdragon 8 Gen 2', 'Snapdragon 870', 'MediaTek Dimensity 7050', 'Exynos 1380', 'Snapdragon G3x Gen 1', 'A14 Bionic']],
            ['slug' => 'cpu_cores', 'name' => 'Количество ядер', 'type' => 'integer', 'options' => [2, 4, 6, 8, 10, 12, 14, 16, 20, 24]],
            ['slug' => 'gpu_type', 'name' => 'Тип видеокарты', 'type' => 'multiselect', 'options' => ['Интегрированная', 'Дискретная']],
            ['slug' => 'gpu_manufacturer', 'name' => 'Производитель видеочипа', 'type' => 'multiselect', 'options' => ['NVIDIA', 'AMD', 'Intel', 'Apple']],
            ['slug' => 'gpu_memory', 'name' => 'Объем видеопамяти', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [2, 4, 6, 8, 10, 12, 16, 24]],
            
            // Атрибуты накопителей
            ['slug' => 'storage_type', 'name' => 'Тип накопителя', 'type' => 'multiselect', 'options' => ['SSD', 'HDD', 'SSD + HDD', 'eMMC', 'SSD M.2 NVMe']],
            ['slug' => 'ssd_volume', 'name' => 'Объем SSD', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [64, 128, 250, 256, 480, 500, 512, 960, 1000, 1024, 2000, 2048, 4000]],
            ['slug' => 'hdd_volume', 'name' => 'Объем HDD', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [500, 1000, 2000, 4000, 6000, 8000]],
            ['slug' => 'interface', 'name' => 'Интерфейс подключения', 'type' => 'multiselect', 'options' => ['USB', 'USB Type-C', 'Bluetooth', 'Радиоканал 2.4 ГГц', 'PCIe 4.0 x4', 'SATA III']],
            
            // Атрибуты периферии
            ['slug' => 'connection_type', 'name' => 'Тип подключения', 'type' => 'multiselect', 'options' => ['Проводное', 'Беспроводное', 'Беспроводное (Радиоканал)', 'Беспроводное (Bluetooth)', 'Проводное/Беспроводное']],
            ['slug' => 'keyboard_backlight', 'name' => 'Подсветка клавиатуры', 'type' => 'multiselect', 'options' => ['Есть (одноцветная)', 'Есть (RGB)', 'Нет', 'Есть (RGB Lightsync)']],
            ['slug' => 'keyboard_type', 'name' => 'Тип клавиатуры', 'type' => 'multiselect', 'options' => ['Мембранная', 'Механическая', 'Оптико-механическая', 'Ножничная']],
            
            // Прочие
            ['slug' => 'os_type', 'name' => 'Операционная система', 'type' => 'multiselect', 'options' => ['Windows 10 Home', 'Windows 10 Pro', 'Windows 11 Home', 'Windows 11 Pro', 'Windows 11', 'macOS', 'Linux', 'ChromeOS', 'Без ОС', 'DOS', 'Android', 'iOS', 'iPadOS']],
            ['slug' => 'nfc_support', 'name' => 'Поддержка NFC', 'type' => 'boolean'],
            ['slug' => 'smart_tv_platform', 'name' => 'Платформа Smart TV', 'type' => 'multiselect', 'options' => ['Tizen', 'webOS', 'Google TV', 'Android TV']],
        ];

        foreach ($attributes as $attr) {
            Attribute::firstOrCreate(
                ['slug' => $attr['slug']],
                [
                    'name' => $attr['name'],
                    'type' => $attr['type'],
                    'options' => $attr['options'] ?? null,
                    'unit' => $attr['unit'] ?? null,
                ]
            );
        }
        $this->command->info('--- AttributeSeeder completed ---');
    }
}