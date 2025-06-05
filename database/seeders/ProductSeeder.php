<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting ProductSeeder...');

        // --- Brand Creation ---
        $brands = [
            'samsung' => Brand::firstOrCreate(['slug' => 'samsung'], ['name' => 'Samsung', 'is_visible' => true]),
            'intel' => Brand::firstOrCreate(['slug' => 'intel'], ['name' => 'Intel', 'is_visible' => true]),
            'nvidia' => Brand::firstOrCreate(['slug' => 'nvidia'], ['name' => 'NVIDIA', 'is_visible' => true]),
            'gigabyte' => Brand::firstOrCreate(['slug' => 'gigabyte'], ['name' => 'Gigabyte', 'is_visible' => true]),
            'xiaomi' => Brand::firstOrCreate(['slug' => 'xiaomi'], ['name' => 'Xiaomi', 'is_visible' => true]),
            'acer' => Brand::firstOrCreate(['slug' => 'acer'], ['name' => 'Acer', 'is_visible' => true]),
            'kingston' => Brand::firstOrCreate(['slug' => 'kingston'], ['name' => 'Kingston', 'is_visible' => true]),
            'asusrog' => Brand::firstOrCreate(['slug' => 'asusrog'], ['name' => 'ASUS ROG', 'is_visible' => true]),
            'asus' => Brand::firstOrCreate(['slug' => 'asus'], ['name' => 'ASUS', 'is_visible' => true]),
            'steelseries' => Brand::firstOrCreate(['slug' => 'steelseries'], ['name' => 'SteelSeries', 'is_visible' => true]),
            'logitech' => Brand::firstOrCreate(['slug' => 'logitech'], ['name' => 'Logitech', 'is_visible' => true]),
            'msi' => Brand::firstOrCreate(['slug' => 'msi'], ['name' => 'MSI', 'is_visible' => true]),
            'lenovo' => Brand::firstOrCreate(['slug' => 'lenovo'], ['name' => 'Lenovo', 'is_visible' => true]),
            'apple' => Brand::firstOrCreate(['slug' => 'apple'], ['name' => 'Apple', 'is_visible' => true]),
            'amd' => Brand::firstOrCreate(['slug' => 'amd'], ['name' => 'AMD', 'is_visible' => true]),
            'corsair' => Brand::firstOrCreate(['slug' => 'corsair'], ['name' => 'Corsair', 'is_visible' => true]),
            'lg' => Brand::firstOrCreate(['slug' => 'lg'], ['name' => 'LG', 'is_visible' => true]),
            'hyperx' => Brand::firstOrCreate(['slug' => 'hyperx'], ['name' => 'HyperX', 'is_visible' => true]),
        ];

        // --- Category Creation ---
        $rootCategories = [
            'laptops-and-other' => Category::updateOrCreate(['slug' => 'laptops-and-other'], ['name' => 'Ноутбуки и аксессуары', 'is_visible' => true, 'sort_order' => 10]),
            'pc-components' => Category::updateOrCreate(['slug' => 'pc-components'], ['name' => 'Комплектующие для ПК', 'is_visible' => true, 'sort_order' => 20]),
            'peripherals' => Category::updateOrCreate(['slug' => 'peripherals'], ['name' => 'Периферия', 'is_visible' => true, 'sort_order' => 30]),
            'smartphones-tablets' => Category::updateOrCreate(['slug' => 'smartphones-tablets'], ['name' => 'Смартфоны и планшеты', 'is_visible' => true, 'sort_order' => 40]),
            'monitors-tv' => Category::updateOrCreate(['slug' => 'monitors-tv'], ['name' => 'Мониторы и ТВ', 'is_visible' => true, 'sort_order' => 50]),
        ];

        $categories = [
            'laptops-notebooks' => Category::updateOrCreate(['slug' => 'laptops-notebooks'], ['name' => 'Ноутбуки', 'parent_id' => $rootCategories['laptops-and-other']->id, 'is_visible' => true, 'sort_order' => 1]),
            'ultrabooks' => Category::updateOrCreate(['slug' => 'ultrabooks'], ['name' => 'Ультрабуки', 'parent_id' => $rootCategories['laptops-and-other']->id, 'is_visible' => true, 'sort_order' => 2]),
            'gaming-laptops' => Category::updateOrCreate(['slug' => 'gaming-laptops'], ['name' => 'Игровые ноутбуки', 'parent_id' => $rootCategories['laptops-and-other']->id, 'is_visible' => true, 'sort_order' => 3]),
            'components-cpu' => Category::updateOrCreate(['slug' => 'components-cpu'], ['name' => 'Процессоры (CPU)', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 1]),
            'components-gpu' => Category::updateOrCreate(['slug' => 'components-gpu'], ['name' => 'Видеокарты (GPU)', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 2]),
            'components-ram' => Category::updateOrCreate(['slug' => 'components-ram'], ['name' => 'Оперативная память (RAM)', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 3]),
            'components-motherboards' => Category::updateOrCreate(['slug' => 'components-motherboards'], ['name' => 'Материнские платы', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 4]),
            'components-ssd' => Category::updateOrCreate(['slug' => 'components-ssd'], ['name' => 'SSD накопители', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 5]),
            'components-hdd' => Category::updateOrCreate(['slug' => 'components-hdd'], ['name' => 'HDD накопители', 'parent_id' => $rootCategories['pc-components']->id, 'is_visible' => true, 'sort_order' => 6]),
            'peripherals-keyboards' => Category::updateOrCreate(['slug' => 'peripherals-keyboards'], ['name' => 'Клавиатуры', 'parent_id' => $rootCategories['peripherals']->id, 'is_visible' => true, 'sort_order' => 1]),
            'peripherals-mice' => Category::updateOrCreate(['slug' => 'peripherals-mice'], ['name' => 'Мыши', 'parent_id' => $rootCategories['peripherals']->id, 'is_visible' => true, 'sort_order' => 2]),
            'peripherals-headsets' => Category::updateOrCreate(['slug' => 'peripherals-headsets'], ['name' => 'Наушники и гарнитуры', 'parent_id' => $rootCategories['peripherals']->id, 'is_visible' => true, 'sort_order' => 3]),
            'smartfony' => Category::updateOrCreate(['slug' => 'smartfony'], ['name' => 'Смартфоны', 'parent_id' => $rootCategories['smartphones-tablets']->id, 'is_visible' => true, 'sort_order' => 1]),
            'tablets' => Category::updateOrCreate(['slug' => 'tablets'], ['name' => 'Планшеты', 'parent_id' => $rootCategories['smartphones-tablets']->id, 'is_visible' => true, 'sort_order' => 2]),
            'monitory-dlya-pk' => Category::updateOrCreate(['slug' => 'monitory-dlya-pk'], ['name' => 'Мониторы для ПК', 'parent_id' => $rootCategories['monitors-tv']->id, 'is_visible' => true, 'sort_order' => 1]),
            'televizory' => Category::updateOrCreate(['slug' => 'televizory'], ['name' => 'Телевизоры', 'parent_id' => $rootCategories['monitors-tv']->id, 'is_visible' => true, 'sort_order' => 2]),
        ];

        $defaultProductAttributes = [
            'is_visible' => true, 'is_featured' => false, 'is_new' => false, 'on_sale' => false,
            'price' => 100.00, 'sale_price' => null, 'quantity' => 10,
            'sku' => null, 'barcode' => null, 'brand_id' => null, 'category_id' => null,
            'thumbnail_url' => 'https://placehold.co/600x600/EEE/31343C?text=Product',
            'images' => json_encode([
                'https://placehold.co/800x800/DDD/31343C?text=Image+1',
                'https://placehold.co/800x800/CCC/31343C?text=Image+2'
            ]),
            'meta_title' => null, 'meta_description' => null, 'meta_keywords' => null,
        ];

        $productsDataArray = [
            [
                'name' => 'Apple MacBook Air 13" M2 (8C CPU, 8C GPU), 8GB, 256GB SSD, Space Gray',
                'price' => 22999.00, 'quantity' => 10, 'category_id' => $categories['ultrabooks']->id, 'brand_id' => $brands['apple']->id, 'is_new' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/D3D3D3/000000?text=MacBook+Air+M2',
                'images' => ['https://placehold.co/800x800/D3D3D3/000000?text=MacBook+Air+M2+Front', 'https://placehold.co/800x800/C0C0C0/000000?text=MacBook+Air+M2+Side'],
                'description' => 'Ультратонкий и легкий MacBook Air с мощным чипом M2.',
                'attributes_map' => [
                    'screen_size' => 13.6, 'resolution' => '2560x1664', 'matrix_type' => 'IPS',
                    'ram_size' => 8, 'ram_type' => 'Unified', 'cpu_series' => 'Apple M2',
                    'cpu_cores' => 8, 'gpu_model' => '8-core GPU', 'storage_type' => 'SSD',
                    'ssd_volume' => 256, 'os_type' => 'macOS', 'keyboard_backlight' => 'Есть (одноцветная)',
                    'color' => 'Серый космос', 'material' => 'Алюминий', 'warranty' => 12, 'touchscreen' => false
                ]
            ],
            [
                'name' => 'ASUS ROG Strix SCAR 17 G733, Ryzen 9 7945HX3D, 32GB, 2TB SSD, RTX 4090 16GB',
                'price' => 75990.00, 'quantity' => 3, 'category_id' => $categories['gaming-laptops']->id, 'brand_id' => $brands['asusrog']->id, 'is_featured' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/333333/FFFFFF?text=ROG+Strix+SCAR+17',
                'images' => ['https://placehold.co/800x800/333333/FFFFFF?text=ROG+Strix+Angle', 'https://placehold.co/800x800/444444/FFFFFF?text=ROG+Strix+Keyboard'],
                'description' => 'Максимальная производительность для киберспорта.',
                'attributes_map' => [
                    'screen_size' => 17.3, 'resolution' => '2560x1440 (QHD)', 'matrix_type' => 'IPS',
                    'refresh_rate' => 240, 'ram_size' => 32, 'ram_type' => 'DDR5',
                    'cpu_series' => 'AMD Ryzen 9', 'cpu_model' => '7945HX3D', 'cpu_cores' => 16,
                    'storage_type' => 'SSD', 'ssd_volume' => 2000, 'gpu_manufacturer' => 'NVIDIA',
                    'gpu_model' => 'GeForce RTX 4090 Laptop', 'gpu_memory' => 16, 'os_type' => 'Windows 11 Pro',
                    'keyboard_backlight' => 'Есть (RGB)', 'color' => 'Черный', 'warranty' => 24
                ]
            ],
            [
                'name' => 'LG UltraGear 27GP850-B, 27" QHD Nano IPS 165Hz',
                'price' => 8990.00, 'quantity' => 15, 'category_id' => $categories['monitory-dlya-pk']->id, 'brand_id' => $brands['lg']->id,
                'thumbnail_url' => 'https://placehold.co/600x600/1E90FF/FFFFFF?text=LG+UltraGear+27',
                'images' => ['https://placehold.co/800x800/1E90FF/FFFFFF?text=LG+Monitor+Front', 'https://placehold.co/800x800/4682B4/FFFFFF?text=LG+Monitor+Back'],
                'description' => 'Игровой монитор с Nano IPS матрицей и G-Sync Compatible.',
                'attributes_map' => [
                    'screen_size' => 27.0, 'resolution' => '2560x1440 (QHD)', 'matrix_type' => 'Nano IPS',
                    'refresh_rate' => 165, 'response_time' => 1, 'aspect_ratio' => '16:9',
                    'brightness' => 350, 'hdr_support' => 'DisplayHDR 400',
                    'ports_video' => '2x HDMI, 1x DisplayPort', 'color' => 'Черный', 'warranty' => 24
                ]
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra 12/512GB Titanium Gray',
                'price' => 28900.00, 'quantity' => 20, 'category_id' => $categories['smartfony']->id, 'brand_id' => $brands['samsung']->id, 'is_new' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/808080/FFFFFF?text=S24+Ultra',
                'images' => ['https://placehold.co/800x800/808080/FFFFFF?text=S24+Ultra+Front', 'https://placehold.co/800x800/A9A9A9/FFFFFF?text=S24+Ultra+Back'],
                'description' => 'Флагманский смартфон с Galaxy AI.',
                'attributes_map' => [
                    'screen_size' => 6.8, 'resolution' => '3120x1440 (QHD+)', 'matrix_type' => 'Dynamic AMOLED 2X',
                    'refresh_rate' => 120, 'ram_size' => 12, 'cpu_series' => 'Snapdragon 8 Gen 3 for Galaxy',
                    'storage_type' => 'UFS 4.0', 'ssd_volume' => 512, 'os_type' => 'Android',
                    'main_camera_mp' => '200+50+12+10', 'battery_capacity' => 5000, 'nfc_support' => true,
                    'color' => 'Титановый Серый', 'material' => 'Титан, Стекло', 'warranty' => 12,
                    'sim_cards' => '2 + eSIM', 'network_support' => '5G, LTE'
                ]
            ],
            [
                'name' => 'Kingston KC3000 1TB NVMe PCIe 4.0 SSD',
                'price' => 2150.00, 'quantity' => 30, 'category_id' => $categories['components-ssd']->id, 'brand_id' => $brands['kingston']->id,
                'thumbnail_url' => 'https://placehold.co/600x600/FF0000/FFFFFF?text=Kingston+KC3000',
                'images' => ['https://placehold.co/800x800/FF0000/FFFFFF?text=KC3000+Top'],
                'description' => 'Высокопроизводительный SSD для геймеров.',
                'attributes_map' => [
                    'storage_type' => 'SSD M.2 NVMe', 'ssd_volume' => 1000,
                    'interface' => 'PCIe 4.0 x4', 'warranty' => 60
                ]
            ],
            [
                'name' => 'Logitech G Pro X TKL Lightspeed Keyboard (Tactile)',
                'price' => 3200.00, 'quantity' => 12, 'category_id' => $categories['peripherals-keyboards']->id, 'brand_id' => $brands['logitech']->id, 'is_featured' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/0000FF/FFFFFF?text=Logitech+G+Pro+X',
                'images' => ['https://placehold.co/800x800/0000FF/FFFFFF?text=G+Pro+X+Keyboard'],
                'description' => 'Компактная беспроводная игровая клавиатура.',
                'attributes_map' => [
                    'connection_type' => 'Беспроводное (Радиоканал)', 'keyboard_type' => 'Механическая',
                    'switch_type' => 'GX Brown Tactile (сменные)', 'keyboard_backlight' => 'Есть (RGB Lightsync)',
                    'color' => 'Черный', 'material' => 'Пластик, Металлическая пластина', 'warranty' => 24
                ]
            ],
            [
                'name' => 'Процессор Intel Core i7-14700K LGA1700 BOX',
                'price' => 9500.00, 'quantity' => 8, 'category_id' => $categories['components-cpu']->id, 'brand_id' => $brands['intel']->id, 'is_new' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/008080/FFFFFF?text=i7-14700K',
                'description' => 'Новейший процессор Intel Core i7 14-го поколения для высокой производительности.',
                'attributes_map' => [
                    'cpu_series' => 'Intel Core i7', 'cpu_model' => '14700K', 'cpu_cores' => 20, // 8P + 12E
                    'ram_type' => 'DDR5/DDR4', 'gpu_type' => 'Интегрированная Intel UHD Graphics 770',
                    'warranty' => 36, 'material' => 'OEM Box'
                ]
            ],
            [
                'name' => 'Видеокарта ASUS ROG Strix GeForce RTX 4070 Ti SUPER OC 16GB',
                'price' => 23500.00, 'quantity' => 5, 'category_id' => $categories['components-gpu']->id, 'brand_id' => $brands['asusrog']->id, 'is_featured' => true,
                'thumbnail_url' => 'https://placehold.co/600x600/4B0082/FFFFFF?text=RTX+4070TiS',
                'description' => 'Мощная видеокарта для игр в 4K с трассировкой лучей.',
                'attributes_map' => [
                    'gpu_manufacturer' => 'NVIDIA', 'gpu_model' => 'GeForce RTX 4070 Ti SUPER OC',
                    'gpu_memory' => 16, 'ram_type' => 'GDDR6X', // Video RAM type
                    'ports_video' => '3x DisplayPort 1.4a, 2x HDMI 2.1',
                    'warranty' => 36, 'dimensions' => '336 x 150 x 63 мм'
                ]
            ],
        ];

        $allDbAttributes = Attribute::all()->keyBy('slug');

        foreach ($productsDataArray as $productData) {
            $productAttributesToSave = $productData['attributes_map'] ?? [];
            unset($productData['attributes_map']);
            unset($productData['specifications']);

            if (isset($productData['images']) && is_array($productData['images'])) {
                $productData['images'] = json_encode($productData['images']);
            } elseif (!isset($productData['images'])) {
                $productData['images'] = $defaultProductAttributes['images'];
            }
            if (!isset($productData['thumbnail_url'])) {
                $productData['thumbnail_url'] = $defaultProductAttributes['thumbnail_url'];
            }

            $finalProductData = array_merge($defaultProductAttributes, $productData);

            if (empty($finalProductData['sku'])) $finalProductData['sku'] = Str::upper(Str::random(4) . '-' . Str::random(6));
            if (empty($finalProductData['meta_title'])) $finalProductData['meta_title'] = $finalProductData['name'] . ' - купить в Aura Computers';
            if (empty($finalProductData['meta_description'])) $finalProductData['meta_description'] = 'Купить ' . $finalProductData['name'] . '. ' . Str::limit(strip_tags($finalProductData['description'] ?? ''), 150);

            $slug = Str::slug($finalProductData['name'], '-');
            $originalSlug = $slug; $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', ($finalProductData['id'] ?? null))->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $finalProductData['slug'] = $slug;

            $createdProduct = Product::updateOrCreate(['slug' => $finalProductData['slug']], $finalProductData);

            if ($createdProduct && !empty($productAttributesToSave)) {
                foreach ($productAttributesToSave as $specNameOrSlug => $attributeData) {
                    $attributeSlug = is_array($attributeData) ? ($attributeData['slug'] ?? null) : $specNameOrSlug;
                    $attributeValue = is_array($attributeData) ? ($attributeData['value'] ?? null) : $attributeData;

                    if (!$attributeSlug) {
                        Log::warning("Missing slug for spec '{$specNameOrSlug}' on product '{$createdProduct->name}'.");
                        continue;
                    }

                    if (isset($allDbAttributes[$attributeSlug])) {
                        $dbAttribute = $allDbAttributes[$attributeSlug];

                        if ($attributeSlug === 'ssd_volume_tb' && isset($allDbAttributes['ssd_volume'])) {
                            $dbAttribute = $allDbAttributes['ssd_volume'];
                            $attributeValue = (is_numeric($attributeValue)) ? (float)$attributeValue * 1000 : null;
                        }

                        if ($attributeValue !== null && (is_string($attributeValue) ? trim($attributeValue) !== '' : true) ) {
                            $pav = ProductAttributeValue::updateOrCreate(
                                ['product_id' => $createdProduct->id, 'attribute_id' => $dbAttribute->id],
                                []
                            );
                            $pav->setRelation('attributeDefinition', $dbAttribute);
                            $pav->value = $attributeValue;
                            $pav->save();
                        }
                    } else {
                        $this->command->warn("Attribute with slug '{$attributeSlug}' not found in DB for product '{$createdProduct->name}'. Spec name was '{$specNameOrSlug}'. Ensure this attribute is defined in AttributeSeeder.");
                    }
                }
            }
        }
        $this->command->info('Product seeding completed.');
    }
}
