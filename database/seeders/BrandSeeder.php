<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('----------------------------------------------------');
        $this->command->info('--- Starting BrandSeeder ---');
        Log::channel('stderr')->info('BrandSeeder: --- RUNNING ---');

        $brandsData = [
            ['slug' => 'samsung', 'name' => 'Samsung'], ['slug' => 'intel', 'name' => 'Intel'],
            ['slug' => 'nvidia', 'name' => 'NVIDIA'], ['slug' => 'gigabyte', 'name' => 'Gigabyte'],
            ['slug' => 'xiaomi', 'name' => 'Xiaomi'], ['slug' => 'acer', 'name' => 'Acer'],
            ['slug' => 'kingston', 'name' => 'Kingston'], ['slug' => 'asusrog', 'name' => 'ASUS ROG'],
            ['slug' => 'asus', 'name' => 'ASUS'], ['slug' => 'steelseries', 'name' => 'SteelSeries'],
            ['slug' => 'logitech', 'name' => 'Logitech'], ['slug' => 'msi', 'name' => 'MSI'],
            ['slug' => 'lenovo', 'name' => 'Lenovo'], ['slug' => 'apple', 'name' => 'Apple'],
            ['slug' => 'amd', 'name' => 'AMD'], ['slug' => 'corsair', 'name' => 'Corsair'],
            ['slug' => 'lg', 'name' => 'LG'], ['slug' => 'hyperx', 'name' => 'HyperX'],
        ];

        foreach ($brandsData as $brandDetails) {
            $brand = Brand::firstOrCreate(
                ['slug' => $brandDetails['slug']],
                ['name' => $brandDetails['name'], 'is_visible' => true]
            );
            Log::channel('stderr')->info("BrandSeeder: Ensured brand '{$brand->name}' (Slug: {$brand->slug}) exists.");
        }

        $this->command->info('--- BrandSeeder completed ---');
        Log::channel('stderr')->info('BrandSeeder: --- COMPLETED ---');
    }
}
