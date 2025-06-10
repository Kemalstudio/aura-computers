<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Facades\Log; // For better logging within seeder

class CategoryAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting CategoryAttributeSeeder...');
        Log::channel('stderr')->info('CategoryAttributeSeeder: Running...'); // Log to console output too

        // Define which attributes belong to which categories and if they are filterable
        // Keys are category slugs, values are arrays of attribute slugs for that category.
        $categoryAttributeMap = [
            // Laptops & Ultrabooks
            'laptops-notebooks' => [
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'touchscreen',
                'ram_size',
                'ram_type',
                'cpu_series',
                'cpu_model',
                'cpu_cores',
                'storage_type',
                'ssd_volume',
                'hdd_volume',
                'gpu_type',
                'gpu_manufacturer',
                'gpu_model',
                'gpu_memory',
                'os_type',
                'webcam',
                'keyboard_backlight',
                'color',
                'material',
                'warranty',
                'weight_kg',
                'dimensions'
            ],
            'ultrabooks' => [ // Often shares many with laptops, but could have specifics
                'screen_size',
                'resolution',
                'matrix_type',
                'touchscreen',
                'ram_size',
                'ram_type',
                'cpu_series',
                'cpu_model',
                'cpu_cores',
                'storage_type',
                'ssd_volume',
                'gpu_type',
                'gpu_manufacturer', // Often integrated
                'os_type',
                'webcam',
                'keyboard_backlight',
                'color',
                'material',
                'warranty',
                'weight_kg',
                'dimensions'
            ],
            'gaming-laptops' => [ // More performance-oriented attributes
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'ram_size',
                'ram_type',
                'cpu_series',
                'cpu_model',
                'cpu_cores',
                'storage_type',
                'ssd_volume',
                'hdd_volume',
                'gpu_type',
                'gpu_manufacturer',
                'gpu_model',
                'gpu_memory',
                'os_type',
                'webcam',
                'keyboard_backlight',
                'color',
                'material',
                'warranty',
                'weight_kg',
                'dimensions',
                'ports_video'
            ],

            // ================== ДОБАВЛЕНО ==================
            'bags-and-backpacks' => [
                'material',
                'color',
                'warranty',
                'weight_kg',
                'dimensions',
                'screen_size' // Для указания совместимости с диагональю ноутбука
            ],
            // ===============================================

            // PC Components
            'components-cpu' => [
                'cpu_series',
                'cpu_model',
                'cpu_cores',
                'ram_type',
                'gpu_type', // Integrated GPU info
                'warranty'
            ],
            'components-gpu' => [
                'gpu_manufacturer',
                'gpu_model',
                'gpu_memory',
                'ram_type', // Video RAM
                'ports_video',
                'refresh_rate', // Max supported by card
                'warranty',
                'dimensions'
            ],
            'components-ram' => [
                'ram_size',
                'ram_type',
                'refresh_rate', // RAM speed often linked to refresh rate in marketing
                'color', // For RGB RAM
                'warranty'
            ],
            'components-motherboards' => [ // Example, add attributes like chipset, form_factor, RAM slots etc.
                'cpu_series', // Compatible CPU series
                'ram_type',
                'storage_type',
                'warranty'
            ],
            'components-ssd' => [
                'storage_type',
                'ssd_volume',
                'interface',
                'warranty'
            ],
            'components-hdd' => [
                'storage_type',
                'hdd_volume',
                'interface',
                'warranty'
            ],

            // Peripherals
            'peripherals-keyboards' => [
                'connection_type',
                'interface',
                'keyboard_type',
                'switch_type',
                'keyboard_backlight',
                'color',
                'material',
                'warranty',
                'weight_kg'
            ],
            'peripherals-mice' => [
                'connection_type',
                'interface',
                'sensor_type',
                'dpi',
                'buttons_count',
                'color',
                'keyboard_backlight', // Some mice have minor lighting
                'warranty',
                'weight_kg'
            ],
            'peripherals-headsets' => [
                'connection_type',
                'interface',
                'color',
                'warranty',
                'weight_kg',
                'material'
                // Add attributes like driver_size, frequency_response, microphone_type etc.
            ],

            // Smartphones & Tablets
            'smartfony' => [
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'touchscreen',
                'ram_size',
                'ram_type',
                'cpu_series',
                'cpu_model',
                'storage_type',
                'ssd_volume', // Using ssd_volume for internal storage
                'os_type',
                'sim_cards',
                'network_support',
                'main_camera_mp',
                'front_camera_mp',
                'battery_capacity',
                'nfc_support',
                'color',
                'material',
                'warranty',
                'weight_kg'
            ],
            'tablets' => [
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'touchscreen',
                'ram_size',
                'ram_type',
                'cpu_series',
                'cpu_model',
                'storage_type',
                'ssd_volume',
                'os_type',
                'sim_cards',
                'network_support',
                'main_camera_mp',
                'front_camera_mp',
                'battery_capacity',
                'color',
                'material',
                'warranty',
                'weight_kg'
            ],

            // Monitors & TV
            'monitory-dlya-pk' => [
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'response_time',
                'aspect_ratio',
                'brightness',
                'contrast_ratio',
                'hdr_support',
                'ports_video',
                'color',
                'warranty',
                'weight_kg',
                'dimensions'
            ],
            'televizory' => [ // Example, add specific TV attributes
                'screen_size',
                'resolution',
                'matrix_type',
                'refresh_rate',
                'hdr_support',
                'os_type', // Smart TV OS
                'ports_video',
                'color',
                'warranty',
                'weight_kg',
                'dimensions'
            ]
        ];

        foreach ($categoryAttributeMap as $categorySlug => $attributeSlugs) {
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                $message = "CategoryAttributeSeeder: Category with slug '{$categorySlug}' not found. Skipping.";
                $this->command->warn($message);
                Log::warning($message);
                continue;
            }

            $attributesToSyncModels = Attribute::whereIn('slug', $attributeSlugs)->get();
            if ($attributesToSyncModels->isEmpty() && !empty($attributeSlugs)) {
                $message = "CategoryAttributeSeeder: No attributes found for defined slugs for category '{$category->name}'. Slugs: " . implode(', ', $attributeSlugs);
                $this->command->warn($message);
                Log::warning($message);
                continue;
            }

            $syncData = [];
            $sortOrder = 0;

            foreach ($attributeSlugs as $slug) {
                $attributeModel = $attributesToSyncModels->firstWhere('slug', $slug);
                if ($attributeModel) {
                    $syncData[$attributeModel->id] = [
                        'is_filterable' => true,   
                        'is_required' => false,        
                        'is_variant_defining' => false, 
                        'sort_order' => $sortOrder++
                    ];
                } else {
                    $message = "CategoryAttributeSeeder: Attribute with slug '{$slug}' (for category '{$category->name}') not found in attributes table during sync prep.";
                    $this->command->warn($message);
                    Log::warning($message);
                }
            }

            if (!empty($syncData)) {
                $category->attributes()->sync($syncData); 
                $message = "CategoryAttributeSeeder: Synced " . count($syncData) . " attributes for category '{$category->name}'.";
                $this->command->info($message);
                Log::info($message);
            } else {
                $message = "CategoryAttributeSeeder: No valid attributes to sync for category '{$category->name}'.";
                $this->command->warn($message);
                Log::warning($message);
            }
        }
        $this->command->info('CategoryAttributeSeeder: Completed.');
        Log::channel('stderr')->info('CategoryAttributeSeeder: Completed.');
    }
}