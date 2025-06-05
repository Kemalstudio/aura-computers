<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('----------------------------------------------------');
        $this->command->info('--- Starting CategorySeeder ---');
        Log::channel('stderr')->info('CategorySeeder: --- RUNNING ---');

        $rootCategoriesData = [
            ['slug' => 'laptops-and-other', 'name' => 'Ноутбуки и аксессуары', 'description' => 'Все для ноутбуков и мобильной работы.', 'is_visible' => true, 'sort_order' => 10],
            ['slug' => 'pc-components', 'name' => 'Комплектующие для ПК', 'description' => 'Собери или обнови свой ПК.', 'is_visible' => true, 'sort_order' => 20],
            ['slug' => 'peripherals', 'name' => 'Периферия', 'description' => 'Клавиатуры, мыши, наушники и другое.', 'is_visible' => true, 'sort_order' => 30],
            ['slug' => 'smartphones-tablets', 'name' => 'Смартфоны и планшеты', 'description' => 'Мобильные устройства и гаджеты.', 'is_visible' => true, 'sort_order' => 40],
            ['slug' => 'monitors-tv', 'name' => 'Мониторы и ТВ', 'description' => 'Экраны для работы и развлечений.', 'is_visible' => true, 'sort_order' => 50],
        ];

        $createdRootCategoriesBySlug = []; // Store created root categories keyed by slug
        foreach ($rootCategoriesData as $data) {
            $category = Category::updateOrCreate(['slug' => $data['slug']], $data);
            $createdRootCategoriesBySlug[$data['slug']] = $category; // Store the model object
            Log::channel('stderr')->info("CategorySeeder: Ensured root category '{$category->name}' (Slug: {$category->slug}, ID: {$category->id}) exists.");
        }

        $subCategoriesData = [
            // Laptops
            ['slug' => 'laptops-notebooks', 'name' => 'Ноутбуки', 'parent_slug' => 'laptops-and-other', 'description' => 'Различные модели ноутбуков.', 'is_visible' => true, 'sort_order' => 1],
            ['slug' => 'ultrabooks', 'name' => 'Ультрабуки', 'parent_slug' => 'laptops-and-other', 'description' => 'Тонкие и легкие ноутбуки.', 'is_visible' => true, 'sort_order' => 2],
            ['slug' => 'gaming-laptops', 'name' => 'Игровые ноутбуки', 'parent_slug' => 'laptops-and-other', 'description' => 'Мощные ноутбуки для игр.', 'is_visible' => true, 'sort_order' => 3],
            // PC Components
            ['slug' => 'components-cpu', 'name' => 'Процессоры (CPU)', 'parent_slug' => 'pc-components', 'description' => 'Центральные процессоры.', 'is_visible' => true, 'sort_order' => 1],
            ['slug' => 'components-gpu', 'name' => 'Видеокарты (GPU)', 'parent_slug' => 'pc-components', 'description' => 'Графические карты.', 'is_visible' => true, 'sort_order' => 2],
            ['slug' => 'components-ram', 'name' => 'Оперативная память (RAM)', 'parent_slug' => 'pc-components', 'description' => 'Модули ОЗУ.', 'is_visible' => true, 'sort_order' => 3],
            ['slug' => 'components-motherboards', 'name' => 'Материнские платы', 'parent_slug' => 'pc-components', 'description' => 'Системные платы.', 'is_visible' => true, 'sort_order' => 4],
            ['slug' => 'components-ssd', 'name' => 'SSD накопители', 'parent_slug' => 'pc-components', 'description' => 'Твердотельные накопители.', 'is_visible' => true, 'sort_order' => 5],
            ['slug' => 'components-hdd', 'name' => 'HDD накопители', 'parent_slug' => 'pc-components', 'description' => 'Жесткие диски.', 'is_visible' => true, 'sort_order' => 6],
            // Peripherals
            ['slug' => 'peripherals-keyboards', 'name' => 'Клавиатуры', 'parent_slug' => 'peripherals', 'description' => 'Устройства ввода текста.', 'is_visible' => true, 'sort_order' => 1],
            ['slug' => 'peripherals-mice', 'name' => 'Мыши', 'parent_slug' => 'peripherals', 'description' => 'Компьютерные мыши.', 'is_visible' => true, 'sort_order' => 2],
            ['slug' => 'peripherals-headsets', 'name' => 'Наушники и гарнитуры', 'parent_slug' => 'peripherals', 'description' => 'Аудио гарнитуры.', 'is_visible' => true, 'sort_order' => 3],
            // Smartphones & Tablets
            ['slug' => 'smartfony', 'name' => 'Смартфоны', 'parent_slug' => 'smartphones-tablets', 'description' => 'Мобильные телефоны.', 'is_visible' => true, 'sort_order' => 1],
            ['slug' => 'tablets', 'name' => 'Планшеты', 'parent_slug' => 'smartphones-tablets', 'description' => 'Планшетные компьютеры.', 'is_visible' => true, 'sort_order' => 2],
            // Monitors & TV
            ['slug' => 'monitory-dlya-pk', 'name' => 'Мониторы для ПК', 'parent_slug' => 'monitors-tv', 'description' => 'Дисплеи для компьютеров.', 'is_visible' => true, 'sort_order' => 1],
            ['slug' => 'televizory', 'name' => 'Телевизоры', 'parent_slug' => 'monitors-tv', 'description' => 'Телевизионные приемники.', 'is_visible' => true, 'sort_order' => 2],
        ];

        foreach ($subCategoriesData as $data) {
            $parentSlug = $data['parent_slug']; // Store parent slug before unsetting
            if (isset($createdRootCategoriesBySlug[$parentSlug])) {
                $data['parent_id'] = $createdRootCategoriesBySlug[$parentSlug]->id;
                $slugToFind = $data['slug'];
                unset($data['parent_slug']); // Remove parent_slug as it's not a DB column for Category

                $category = Category::updateOrCreate(['slug' => $slugToFind], $data);

                // Use the stored parentSlug to get the parent name from $createdRootCategoriesBySlug
                Log::channel('stderr')->info("CategorySeeder: Ensured sub-category '{$category->name}' (Slug: {$category->slug}, ID: {$category->id}) under parent '{$createdRootCategoriesBySlug[$parentSlug]->name}'.");
            } else {
                $message = "CategorySeeder: Parent category with slug '{$parentSlug}' not found for sub-category '{$data['name']}'. Skipping.";
                $this->command->warn($message);
                Log::channel('stderr')->warn($message);
            }
        }
        $this->command->info('--- CategorySeeder completed ---');
        Log::channel('stderr')->info('CategorySeeder: --- COMPLETED ---');
    }
}
