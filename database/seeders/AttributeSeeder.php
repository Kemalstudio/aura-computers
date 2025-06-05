<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use Illuminate\Support\Facades\Log;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('----------------------------------------------------');
        $this->command->info('--- Starting AttributeSeeder ---');
        Log::channel('stderr')->info('AttributeSeeder: --- RUNNING ---');

        $attributes = [
            // ... (Your full list of attributes from the previous response) ...
            // Example:
            ['slug' => 'screen_size', 'name' => 'Диагональ экрана', 'type' => 'decimal', 'unit' => '"', 'options' => [13.3, 14.0, 15.6, 16.0, 17.3, 23.8, 27.0, 31.5]],
            ['slug' => 'color', 'name' => 'Цвет', 'type' => 'select', 'options' => ['Черный', 'Белый', 'Серый', 'Серебристый', 'Красный', 'Синий', 'Зеленый', 'Золотой', 'Розовый']],
            ['slug' => 'refresh_rate', 'name' => 'Частота обновления', 'type' => 'integer', 'unit' => 'Гц', 'options' => [60, 75, 120, 144, 165, 240, 360]],
            ['slug' => 'resolution', 'name' => 'Разрешение экрана', 'type' => 'select', 'options' => ['1366x768 (HD)', '1920x1080 (FHD)', '2560x1440 (QHD)', '3840x2160 (4K UHD)', '2560x1600 (WQXGA)']],
            ['slug' => 'matrix_type', 'name' => 'Тип матрицы', 'type' => 'select', 'options' => ['IPS', 'OLED', 'TN', 'VA', 'PLS', 'AHVA']],
            ['slug' => 'touchscreen', 'name' => 'Сенсорный экран', 'type' => 'boolean'],
            ['slug' => 'ram_size', 'name' => 'Объем ОЗУ', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [4, 8, 12, 16, 24, 32, 64]],
            ['slug' => 'ram_type', 'name' => 'Тип ОЗУ', 'type' => 'select', 'options' => ['DDR3', 'DDR4', 'DDR5', 'LPDDR3', 'LPDDR4X', 'LPDDR5']],
            ['slug' => 'cpu_series', 'name' => 'Серия процессора', 'type' => 'select', 'options' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'Intel Pentium', 'Intel Celeron', 'AMD Ryzen 3', 'AMD Ryzen 5', 'AMD Ryzen 7', 'AMD Ryzen 9', 'AMD Athlon', 'Apple M1', 'Apple M2', 'Apple M3']],
            ['slug' => 'cpu_model', 'name' => 'Модель процессора', 'type' => 'text'],
            ['slug' => 'cpu_cores', 'name' => 'Количество ядер', 'type' => 'integer', 'options' => [2, 4, 6, 8, 10, 12, 14, 16, 20, 24]],
            ['slug' => 'storage_type', 'name' => 'Тип накопителя', 'type' => 'select', 'options' => ['SSD', 'HDD', 'SSD + HDD', 'eMMC', 'SSD M.2 NVMe']],
            ['slug' => 'ssd_volume', 'name' => 'Объем SSD', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [128, 250, 256, 480, 500, 512, 960, 1000, 1024, 2000, 2048, 4000]],
            ['slug' => 'hdd_volume', 'name' => 'Объем HDD', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [500, 1000, 2000, 4000, 6000, 8000]],
            ['slug' => 'gpu_type', 'name' => 'Тип видеокарты', 'type' => 'select', 'options' => ['Интегрированная', 'Дискретная', 'Интегрированная Intel UHD Graphics 770']],
            ['slug' => 'gpu_manufacturer', 'name' => 'Производитель видеочипа', 'type' => 'select', 'options' => ['NVIDIA', 'AMD', 'Intel', 'Apple']],
            ['slug' => 'gpu_model', 'name' => 'Модель видеокарты', 'type' => 'text'],
            ['slug' => 'gpu_memory', 'name' => 'Объем видеопамяти', 'type' => 'integer', 'unit' => 'ГБ', 'options' => [2, 4, 6, 8, 10, 12, 16, 24]],
            ['slug' => 'os_type', 'name' => 'Операционная система', 'type' => 'select', 'options' => ['Windows 10 Home', 'Windows 10 Pro', 'Windows 11 Home', 'Windows 11 Pro', 'macOS', 'Linux', 'ChromeOS', 'Без ОС', 'DOS', 'Android', 'нет (опционально)']],
            ['slug' => 'webcam', 'name' => 'Веб-камера', 'type' => 'select', 'options' => ['Есть (HD)', 'Есть (Full HD)', 'Нет']],
            ['slug' => 'keyboard_backlight', 'name' => 'Подсветка клавиатуры', 'type' => 'select', 'options' => ['Есть (одноцветная)', 'Есть (RGB)', 'Нет', 'Есть (RGB Lightsync)']],
            ['slug' => 'material', 'name' => 'Материал корпуса', 'type' => 'select', 'options' => ['Пластик', 'Металл', 'Алюминий', 'Стекло', 'Комбинированный', 'Титан, Стекло', 'Пластик, Металлическая пластина', 'OEM Box']],
            ['slug' => 'warranty', 'name' => 'Гарантия', 'type' => 'integer', 'unit' => 'мес.'],
            ['slug' => 'weight_kg', 'name' => 'Вес', 'type' => 'decimal', 'unit' => 'кг'],
            ['slug' => 'dimensions', 'name' => 'Габариты (ШхВхГ)', 'type' => 'text', 'unit' => 'мм'],
            ['slug' => 'response_time', 'name' => 'Время отклика', 'type' => 'integer', 'unit' => 'мс', 'options' => [1, 2, 4, 5, 8]],
            ['slug' => 'aspect_ratio', 'name' => 'Соотношение сторон', 'type' => 'select', 'options' => ['16:9', '16:10', '21:9', '32:9']],
            ['slug' => 'brightness', 'name' => 'Яркость', 'type' => 'integer', 'unit' => 'кд/м²', 'options' => [250, 300, 350, 400, 600, 1000]],
            ['slug' => 'contrast_ratio', 'name' => 'Контрастность', 'type' => 'text'],
            ['slug' => 'hdr_support', 'name' => 'Поддержка HDR', 'type' => 'select', 'options' => ['DisplayHDR 400', 'DisplayHDR 600', 'DisplayHDR 1000', 'Есть', 'Нет']],
            ['slug' => 'ports_video', 'name' => 'Видео разъемы', 'type' => 'text'],
            ['slug' => 'connection_type', 'name' => 'Тип подключения', 'type' => 'select', 'options' => ['Проводное', 'Беспроводное (Радиоканал)', 'Беспроводное (Bluetooth)', 'Проводное/Беспроводное']],
            ['slug' => 'interface', 'name' => 'Интерфейс подключения', 'type' => 'select', 'options' => ['USB', 'USB Type-C', 'Bluetooth', 'Радиоканал 2.4 ГГц', 'PCIe 4.0 x4']],
            ['slug' => 'sensor_type', 'name' => 'Тип сенсора (мышь)', 'type' => 'select', 'options' => ['Оптический', 'Лазерный', 'Оптический (SteelSeries TrueMove Core)']],
            ['slug' => 'dpi', 'name' => 'Разрешение DPI/CPI (мышь)', 'type' => 'integer', 'unit' => 'DPI'],
            ['slug' => 'buttons_count', 'name' => 'Количество кнопок', 'type' => 'integer'],
            ['slug' => 'keyboard_type', 'name' => 'Тип клавиатуры', 'type' => 'select', 'options' => ['Мембранная', 'Механическая', 'Оптико-механическая', 'Ножничная']],
            ['slug' => 'switch_type', 'name' => 'Тип переключателей (мех.)', 'type' => 'text'],
            ['slug' => 'sim_cards', 'name' => 'Количество SIM-карт', 'type' => 'select', 'options' => ['1', '2', '1 + eSIM', '2 + eSIM']],
            ['slug' => 'network_support', 'name' => 'Поддержка сетей', 'type' => 'text'],
            ['slug' => 'main_camera_mp', 'name' => 'Основная камера', 'type' => 'text', 'unit' => 'Мп'],
            ['slug' => 'front_camera_mp', 'name' => 'Фронтальная камера', 'type' => 'integer', 'unit' => 'Мп'],
            ['slug' => 'battery_capacity', 'name' => 'Емкость аккумулятора', 'type' => 'integer', 'unit' => 'мАч'],
            ['slug' => 'nfc_support', 'name' => 'Поддержка NFC', 'type' => 'boolean'],
            ['slug' => 'max_speed_ips', 'name' => 'Макс. скорость (мышь)', 'type' => 'integer', 'unit' => 'IPS'],
            ['slug' => 'max_acceleration_g', 'name' => 'Макс. ускорение (мышь)', 'type' => 'integer', 'unit' => 'G'],
        ];

        foreach ($attributes as $attr) {
            Attribute::firstOrCreate(
                ['slug' => $attr['slug']],
                [
                    'name' => $attr['name'],
                    'type' => $attr['type'],
                    'options' => $attr['options'] ?? null,
                    'unit' => $attr['unit'] ?? null,
                    'description' => $attr['description'] ?? ($attr['name'] . ' attribute'),
                ]
            );
            Log::channel('stderr')->info("AttributeSeeder: Ensured attribute '{$attr['name']}' (Slug: {$attr['slug']}) exists.");
        }
        $this->command->info('--- AttributeSeeder completed ---');
        Log::channel('stderr')->info('AttributeSeeder: --- COMPLETED ---');
    }
}
