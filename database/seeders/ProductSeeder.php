<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brandSamsung = Brand::firstOrCreate(['slug' => 'samsung'], ['name' => 'Samsung', 'is_visible' => true]);
        $brandIntel = Brand::firstOrCreate(['slug' => 'intel'], ['name' => 'Intel', 'is_visible' => true]);
        $brandNvidia = Brand::firstOrCreate(['slug' => 'nvidia'], ['name' => 'NVIDIA', 'is_visible' => true]);
        $brandGigabyte = Brand::firstOrCreate(['slug' => 'gigabyte'], ['name' => 'Gigabyte', 'is_visible' => true]);
        $brandXiaomi = Brand::firstOrCreate(['slug' => 'xiaomi'], ['name' => 'Xiaomi', 'is_visible' => true]);
        $brandAcer = Brand::firstOrCreate(['slug' => 'acer'], ['name' => 'Acer', 'is_visible' => true]);
        $brandKingston = Brand::firstOrCreate(['slug' => 'kingston'], ['name' => 'Kingston', 'is_visible' => true]);
        $brand2E = Brand::firstOrCreate(['slug' => '2e'], ['name' => '2E', 'is_visible' => true]);
        $brandAsusROG = Brand::firstOrCreate(['slug' => 'asusrog'], ['name' => 'REPUBLIC OF GAMERS', 'is_visible' => true]);
        $brandAsus = Brand::firstOrCreate(['slug' => 'asus'], ['name' => 'ASUS', 'is_visible' => true]);
        $brandSTEELSERIES = Brand::firstOrCreate(['slug' => 'steelseries'], ['name' => 'STEELSERIES', 'is_visible' => true]);
        $brandLogitech = Brand::firstOrCreate(['slug' => 'logitech'], ['name' => 'Logitech', 'is_visible' => true]);
        $brandMSI = Brand::firstOrCreate(['slug' => 'MSI'], ['name' => 'MSI', 'is_visible' => true]);
        $brandLenovo = Brand::firstOrCreate(['slug' => 'Lenovo'], ['name' => 'Lenovo', 'is_visible' => true]);


        $categoryLaptopsParent = Category::updateOrCreate(
            ['slug' => 'laptops-and-other'],
            ['name' => 'Ноутбуки и прочее', 'description' => 'Портативные компьютеры, сумки, аксессуары.', 'is_visible' => true, 'sort_order' => 10]
        );
        $categoryLaptopsNotebooks = Category::updateOrCreate(
            ['slug' => 'laptops-notebooks'],
            ['name' => 'Ноутбуки', 'description' => 'Различные модели ноутбуков.', 'parent_id' => $categoryLaptopsParent->id, 'is_visible' => true, 'sort_order' => 1]
        );

        $categoryComponentsParent = Category::updateOrCreate(
            ['slug' => 'pc-components'],
            ['name' => 'Комплектующие для ПК', 'description' => 'Процессоры, видеокарты, оперативная память и другие компоненты для сборки и апгрейда ПК.', 'is_visible' => true, 'sort_order' => 20]
        );
        $categoryCpu = Category::updateOrCreate(
            ['slug' => 'components-cpu'],
            ['name' => 'Процессоры (CPU)', 'description' => 'Центральные процессоры для компьютеров.', 'parent_id' => $categoryComponentsParent->id, 'is_visible' => true, 'sort_order' => 1]
        );
        $categoryGpu = Category::updateOrCreate(
            ['slug' => 'components-gpu'],
            ['name' => 'Видеокарты (GPU)', 'description' => 'Графические ускорители для игр и профессиональных задач.', 'parent_id' => $categoryComponentsParent->id, 'is_visible' => true, 'sort_order' => 2]
        );
        $categoryRam = Category::updateOrCreate(
            ['slug' => 'components-ram'],
            ['name' => 'Оперативная память (RAM)', 'description' => 'Модули оперативной памяти для ПК и ноутбуков.', 'parent_id' => $categoryComponentsParent->id, 'is_visible' => true, 'sort_order' => 3]
        );

        $categoryPeripheralsParent = Category::updateOrCreate(
            ['slug' => 'peripherals'],
            ['name' => 'Периферия', 'description' => 'Устройства ввода-вывода и другие аксессуары для компьютеров.', 'is_visible' => true, 'sort_order' => 30]
        );
        $categoryKeyboards = Category::updateOrCreate(
            ['slug' => 'peripherals-keyboards'],
            ['name' => 'Клавиатуры', 'description' => 'Механические, мембранные и другие клавиатуры.', 'parent_id' => $categoryPeripheralsParent->id, 'is_visible' => true, 'sort_order' => 1]
        );
        $categoryMice = Category::updateOrCreate(
            ['slug' => 'peripherals-mice'],
            ['name' => 'Мыши', 'description' => 'Игровые и офисные компьютерные мыши.', 'parent_id' => $categoryPeripheralsParent->id, 'is_visible' => true, 'sort_order' => 2]
        );
        $categoryWebcams = Category::updateOrCreate(
            ['slug' => 'peripherals-webcams'],
            ['name' => 'Веб-камеры', 'description' => 'Камеры для видеоконференций и стриминга.', 'parent_id' => $categoryPeripheralsParent->id, 'is_visible' => true, 'sort_order' => 3]
        );


        $categorySmartphonesParent = Category::updateOrCreate(
            ['slug' => 'smartphones'],
            ['name' => 'Смартфоны', 'description' => 'Мобильные телефоны с расширенными возможностями.', 'is_visible' => true, 'sort_order' => 40]
        );
        $categorySmartphonesFlagship = Category::updateOrCreate(
            ['slug' => 'smartphones-flagship'],
            ['name' => 'Флагманы', 'description' => 'Топовые модели смартфонов с максимальной производительностью.', 'parent_id' => $categorySmartphonesParent->id, 'is_visible' => true, 'sort_order' => 1]
        );
        $categorySmartphonesBudget = Category::updateOrCreate(
            ['slug' => 'smartphones-budget'],
            ['name' => 'Бюджетные смартфоны', 'description' => 'Доступные модели смартфонов с хорошим соотношением цена/качество.', 'parent_id' => $categorySmartphonesParent->id, 'is_visible' => true, 'sort_order' => 2]
        );

        $categoryHomeAppliancesParent = Category::updateOrCreate(
            ['slug' => 'home-appliances'],
            ['name' => 'Бытовая техника', 'description' => 'Техника для дома и кухни.', 'is_visible' => true, 'sort_order' => 50]
        );
        $categoryTv = Category::updateOrCreate(
            ['slug' => 'home-appliances-tv'],
            ['name' => 'Телевизоры', 'description' => 'Современные телевизоры с различными технологиями экрана.', 'parent_id' => $categoryHomeAppliancesParent->id, 'is_visible' => true, 'sort_order' => 1]
        );

        $defaultProductAttributes = [
            'is_visible' => true,
            'is_featured' => false,
            'is_new' => false,
            'on_sale' => false,
            'price' => 100.00,
            'sale_price' => null,
            'quantity' => 10,
            'sku' => null,
            'barcode' => null,
            'brand_id' => null,
            'category_id' => null,
            'thumbnail_url' => 'https://via.placeholder.com/300x300.png?text=Product',
            'images' => json_encode([
                'https://via.placeholder.com/600x600.png?text=Image1',
                'https://via.placeholder.com/600x600.png?text=Image2'
            ]),
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => null,
            'specifications' => json_encode([]),
        ];

        $products = [
            [
                'name' => 'Игровой ноутбук ACER NITRO 5 AN515-45-R56R (Процессор AMD Ryzen7 5800H)',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/z5WV57FK5mhdx6XUPKXH.jpg',
                'price' => 16038.00,
                'quantity' => 5,
                'category_id' => $categoryLaptopsNotebooks->id,
                'brand_id' => $brandAcer->id,
                'is_featured' => true,
                'sku' => 'NH.QBAEM.002',
                'description' => 'Игровой ноутбук ACER NITRO 5 AN515-45-R56R (Процессор AMD Ryzen7 5800H / Оперативная память 16GB (DDR4) / SSD 512GB / Диагональ экрана 15.6" дюйма FHD 144Hz IPS / Видеокарта NVIDIA RTX 3050 4GB / Дисковод отсутствует / Язык Английский и Русский / Черный цвет) (NH.QBAEM.002)',
                'long_description' => 'Игровой ноутбук ACER NITRO 5 AN515-45-R56R (Процессор AMD Ryzen7 5800H / Оперативная память 16GB (DDR4) / SSD 512GB / Диагональ экрана 15.6" дюйма FHD 144Hz IPS / Видеокарта NVIDIA RTX 3050 4GB / Дисковод отсутствует / Язык Английский и Русский / Черный цвет) (NH.QBAEM.002). Откройте для себя новый уровень гейминга с ACER NITRO 5. Мощный процессор AMD Ryzen и видеокарта NVIDIA GeForce RTX обеспечивают плавный игровой процесс даже в самых требовательных играх. Яркий IPS-дисплей с высокой частотой обновления 144 Гц гарантирует четкое и детализированное изображение без разрывов. Эффективная система охлаждения CoolBoost позволяет ноутбуку работать на максимальной производительности без перегрева.',
                'specifications' => [
                    'Размер экрана (дюймы)' => 15.6,
                    'Разрешение экрана' => '1920x1080',
                    'Тип матрицы' => 'IPS',
                    'Частота обновления (Гц)' => 144,
                    'Объем ОЗУ (ГБ)' => 16,
                    'Тип ОЗУ' => 'DDR4',
                    'Тип процессора' => 'AMD Ryzen 7 5800H',
                    'Количество ядер процессора' => 8,
                    'Объем SSD (ГБ)' => 512,
                    'Тип видеокарты' => 'NVIDIA GeForce RTX 3050',
                    'Объем видеопамяти (ГБ)' => 4,
                    'Операционная система' => 'Без ОС',
                    'Клавиатура' => 'С подсветкой (красная)',
                    'Беспроводные интерфейсы' => 'Wi-Fi 6, Bluetooth 5.1',
                    'Порты' => '1x HDMI 2.1, 1x USB 3.2 Gen 2 Type-C (DP), 3x USB 3.2 Gen 1 Type-A, RJ45, Audio Jack',
                    'Цвет' => 'Черный',
                    'Вес (кг)' => '2.20',
                    'Батарея' => '57 Вт*ч',
                ]
            ],
            [
                'name' => 'Игровой ноутбук ASUS ROG STRIX G513RC (Процессор AMD Ryzen7 6800H)',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/ackKGWyLq6DY3yPNqQPK.jpg',
                'price' => 21195.00,
                'quantity' => 8,
                'category_id' => $categoryLaptopsNotebooks->id,
                'brand_id' => $brandAsusROG->id,
                'is_featured' => true,
                'sku' => '90NR08A5-M006Z0',
                'description' => 'Игровой ноутбук ASUS ROG STRIX G513RC (Процессор AMD Ryzen7 6800H / Оперативная память 16GB (DDR5) / SSD 512GB / Диагональ экрана 15.6" дюйма FHD 144Hz IPS / Видеокарта NVIDIA RTX 3050 4GB / Мышка ROG IMPACT в комплекте / Серый цвет) (90NR08A5-M006Z0)',
                'long_description' => 'ASUS ROG STRIX G513RC - это мощь и стиль в одном корпусе. Процессор AMD Ryzen 7 6000-й серии и видеокарта NVIDIA GeForce RTX 3050 готовы к любым игровым вызовам. Память DDR5 обеспечивает высочайшую скорость работы. Уникальный дизайн с RGB-подсветкой Aura Sync подчеркнет вашу индивидуальность.',
                'specifications' => [
                    'Размер экрана (дюймы)' => 15.6,
                    'Разрешение экрана' => '1920x1080',
                    'Тип матрицы' => 'IPS',
                    'Частота обновления (Гц)' => 144,
                    'Объем ОЗУ (ГБ)' => 16,
                    'Тип ОЗУ' => 'DDR5',
                    'Тип процессора' => 'AMD Ryzen 7 6800H',
                    'Количество ядер процессора' => 8,
                    'Объем SSD (ГБ)' => 512,
                    'Тип видеокарты' => 'NVIDIA GeForce RTX 3050',
                    'Объем видеопамяти (ГБ)' => 4,
                    'Операционная система' => 'Windows 11 Home',
                    'Клавиатура' => 'С RGB подсветкой (4 зоны)',
                    'Беспроводные интерфейсы' => 'Wi-Fi 6E, Bluetooth 5.2',
                    'Порты' => '1x HDMI 2.0b, 1x USB 3.2 Gen 2 Type-C (DP/PD), 1x USB 3.2 Gen 2 Type-C, 2x USB 3.2 Gen 1 Type-A, RJ45, Audio Jack',
                    'Цвет' => 'Серый (Eclipse Gray)',
                    'Вес (кг)' => '2.10',
                    'Комплектация' => 'Ноутбук, адаптер питания, мышь ROG IMPACT',
                ]
            ],
            [
                'name' => 'Игровой ноутбук LENOVO LEGION PRO 7 16IAX10H (Процессор Intel® Core Ultra 9 275HX)',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/18NWaPLGwTmV95eTd7GX.jpg',
                'price' => 49500.00,
                'quantity' => 4,
                'category_id' => $categoryLaptopsNotebooks->id,
                'brand_id' => $brandLenovo->id,
                'is_featured' => true,
                'is_new' => true,
                'sku' => 'PF5GZ237',
                'description' => 'Игровой ноутбук LENOVO LEGION PRO 7 16IAX10H (Процессор Intel® Core Ultra 9 275HX / Оперативная память 32GB (DDR5) / SSD 1TB / Диагональ экрана 16" дюймов WQXGA OLED 240Hz / Видеокарта NVIDIA RTX 5080 16GB / Дисковод отсутствует / Язык Английский и Русский / Черный цвет) (PF5GZ237) ',
                'long_description' => 'Игровой ноутбук LENOVO LEGION PRO 7 16IAX10H (Процессор Intel® Core Ultra 9 275HX / Оперативная память 32GB (DDR5) / SSD 1TB / Диагональ экрана 16" дюймов WQXGA OLED 240Hz / Видеокарта NVIDIA RTX 5080 16GB / Дисковод отсутствует / Язык Английский и Русский / Черный цвет) (PF5GZ237) ',
                'specifications' => [
                    'Размер экрана (дюймы)' => 16,
                    'Разрешение экрана' => ' 	2560x1600',
                    'Тип матрицы' => 'OLED',
                    'Частота обновления (Гц)' => 240,
                    'Объем ОЗУ (ГБ)' => 32,
                    'Тип ОЗУ' => 'DDR5',
                    'Тип процессора' => 'Intel Ultra 9',
                    'Количество ядер процессора' => 24,
                    'Объем SSD (ТБ)' => 1,
                    'Тип видеокарты' => 'NVIDIA RTX 5080',
                    'Объем видеопамяти (ГБ)' => 16,
                    'Порты подключения' => 'HDMI / 2 х USB 3.2 gen 1 / 1 х USB 3.2 gen 2 / 1 х Type-C 3.2 gen 2 / 1 х Thunderbolt v4 / LAN',
                    'Тип клавиатуры' => 'мембранная',
                    'Язык клавиш' => 'английский',
                    'Ёмкость аккумулятора' => '99.9 Вт/ч',
                    'Операционная система' => 'нет (опционально)',
                    'Цвет' => 'чёрный',
                    'Сканер отпечатка пальца' => 'нет',
                    'Web-камера' => '5 МП (2560x1920)',
                    'Материал корпуса' => 'алюминий / пластик',
                ]
            ],
            [
                'name' => 'Игровой ноутбук MSI CROSSHAIR 17 (Процессор Intel® Core i7-12700H)',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/Z97EcPliyclzWMDmCth5.jpg',
                'price' => 31680.00,
                'quantity' => 13,
                'category_id' => $categoryLaptopsNotebooks->id,
                'brand_id' => $brandMSI->id,
                'is_featured' => true,
                'sku' => '9S7-17L352-288',
                'description' => 'Игровой ноутбук MSI CROSSHAIR 17 (Процессор Intel® Core i7-12700H / Оперативная память 16GB (DDR4) / SSD 1TB / Диагональ экрана 17.3" дюймов FHD IPS 360Hz / Видеокарта NVIDIA RTX 3070 8GB / Дисковод отсутствует / Язык Английский и Русский / Черный с желтым цвет) (9S7-17L352-288) ',
                'long_description' => 'ASUS ROG STRIX G513RC - это мощь и стиль в одном корпусе. Процессор AMD Ryzen 7 6000-й серии и видеокарта NVIDIA GeForce RTX 3050 готовы к любым игровым вызовам. Память DDR5 обеспечивает высочайшую скорость работы. Уникальный дизайн с RGB-подсветкой Aura Sync подчеркнет вашу индивидуальность.',
                'specifications' => [
                    'Размер экрана (дюймы)' => 17.3,
                    'Разрешение экрана' => '1920x1080',
                    'Тип матрицы' => 'IPS',
                    'Частота обновления (Гц)' => 360,
                    'Объем ОЗУ (ГБ)' => 16,
                    'Тип ОЗУ' => 'DDR5',
                    'Тип процессора' => 'Intel Core i7',
                    'Количество ядер процессора' => 14,
                    'Объем SSD (ТБ)' => 1,
                    'Тип видеокарты' => 'NVIDIA RTX 3070',
                    'Объем видеопамяти (ГБ)' => 8,
                    'Тактовая частота' => '2,3 ГГц',
                    'Тип клавиатуры' => 'мембранная',
                    'Подсветка' => 'подсветка клавиатуры',
                    'Беспроводные интерфейсы' => 'Wi-Fi 6E, Bluetooth 5.2',
                    'Порты' => 'HDMI / 1 х USB 2.0 / 2 х USB 3.2 gen 1 / 1 х Type-C 3.2 gen 1 / AUX / LAN',
                    'Цвет' => 'чёрный / жёлтый',
                    'Материал корпуса' => 'пластик',
                    'Ёмкость аккумулятора' => '90 Вт/ч',
                ]
            ],
            [
                'name' => 'Компьютерная мышь ASUS WT425',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/0kCiyd0wydxbvCFxU79i.jpg',
                'price' => 435.60,
                'quantity' => 6,
                'category_id' => $categoryMice->id,
                'brand_id' => $brandAsus->id,
                'is_featured' => true,
                'sku' => '90XB0280-BMU040',
                'description' => 'Компьютерная мышь ASUS WT425 (Беспроводная 2.4GHz / Оптическая / Эргономичная / 1600 DPI / 2 боковые кнопки / Синий цвет) (90XB0280-BMU040)',
                'long_description' => 'Беспроводная оптическая мышь ASUS WT425 обеспечивает комфортную работу благодаря эргономичному дизайну. Разрешение сенсора до 1600 DPI и наличие боковых кнопок делают навигацию удобной.',
                'specifications' => [
                    'Тип подключения' => 'Беспроводное',
                    'Интерфейс подключения' => 'Радиоканал 2.4 ГГц (USB-приемник)',
                    'Сенсор' => 'Оптический',
                    'Максимальное разрешение DPI' => 1600,
                    'Количество кнопок' => 5,
                    'Боковые кнопки' => 'Да (2)',
                    'Тип питания' => '1x AA батарейка',
                    'Радиус действия (м)' => 'до 10',
                    'Дизайн' => 'Эргономичный (для правой руки)',
                    'Цвет' => 'Синий/Черный',
                    'Совместимость с ОС' => 'Windows, macOS, Linux',
                    'Размеры (ДхШхВ, мм)' => '107 x 74 x 39',
                    'Вес (г)' => '65 (без батарейки)',
                ]
            ],
            [
                'name' => 'Компьютерная мышь STEELSERIES AEROX 3',
                'thumbnail_url' => 'https://sumbar-computer.com/storage/sm/ip/3flOUADRwcpN2yOjdWri.jpg',
                'price' => 1247.40,
                'quantity' => 9,
                'category_id' => $categoryMice->id,
                'brand_id' => $brandSTEELSERIES->id,
                'is_new' => true,
                'is_featured' => true,
                'sku' => '62599',
                'description' => 'Ультралегкая игровая мышь STEELSERIES AEROX 3 с перфорированным корпусом, сенсором 8500 CPI, скоростью 300 IPS и RGB-подсветкой. Вес всего 57 грамм.',
                'long_description' => 'SteelSeries Aerox 3 – это сверхлегкая игровая мышь, разработанная для максимальной скорости и производительности. Её уникальный перфорированный дизайн не только снижает вес до невероятных 57 грамм, но и обеспечивает вентиляцию ладони. Мышь оснащена высокоточным оптическим сенсором TrueMove Core.',
                'specifications' => [
                    'Тип подключения' => 'Проводное', 
                    'Интерфейс подключения' => 'USB Type-C (кабель Super Mesh)', 
                    'Сенсор' => 'Оптический (SteelSeries TrueMove Core)',
                    'Максимальное разрешение CPI' => 8500, 
                    'Максимальная скорость (IPS)' => 300, 
                    'Максимальное ускорение (G)' => 35, 
                    'Количество кнопок' => 6,
                    'Тип переключателей' => 'Golden Micro IP54', 
                    'Подсветка' => 'RGB (3 зоны)', 
                    'Длина кабеля (м)' => '1.8',
                    'Материал корпуса' => 'ABS-пластик',
                    'Ножки (глайды)' => 'PTFE',
                    'Цвет' => 'Черный', 
                    'Совместимость с ОС' => 'Windows, macOS, Xbox, Linux',
                    'Размеры (ДхШхВ, мм)' => '120.55x57.91x21.53', 
                    'Вес (г)' => '57', 
                ]
            ],
        ];

        foreach ($products as $productData) {
            if (isset($productData['images']) && is_array($productData['images'])) {
                $productData['images'] = json_encode($productData['images']);
            }
            if (isset($productData['specifications']) && is_array($productData['specifications'])) {
                $productData['specifications'] = json_encode($productData['specifications']);
            }

            $finalProductData = array_merge($defaultProductAttributes, $productData);

            if (empty($finalProductData['sku'])) {
                $finalProductData['sku'] = Str::upper(Str::random(4) . '-' . Str::random(6));
            }
            if (empty($finalProductData['meta_title'])) {
                $finalProductData['meta_title'] = $finalProductData['name'] . ' - купить в Aura Computers';
            }
            if (empty($finalProductData['meta_description'])) {
                $finalProductData['meta_description'] = 'Купить ' . $finalProductData['name'] . '. ' . Str::limit(strip_tags($finalProductData['description'] ?? ''), 150);
            }

            $slug = Str::slug($finalProductData['name'], '-');
            $originalSlug = $slug;
            $count = 1;
            $existingProduct = Product::where('slug', $slug)->first();
            while ($existingProduct && (!isset($finalProductData['id']) || $existingProduct->id !== $finalProductData['id'])) {
                $slug = $originalSlug . '-' . $count++;
                $existingProduct = Product::where('slug', $slug)->first();
            }
            $finalProductData['slug'] = $slug;

            Product::updateOrCreate(
                ['slug' => $finalProductData['slug']],
                $finalProductData
            );
        }
    }
}