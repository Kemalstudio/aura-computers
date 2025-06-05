<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log; // Optional: for overall logging

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('====================================================');
        $this->command->info('========= Starting Main Database Seeder ==========');
        Log::channel('stderr')->info('DatabaseSeeder: --- STARTING ALL SEEDERS ---');

        // Clear existing log for cleaner debugging, optional
        // file_put_contents(storage_path('logs/laravel.log'), '');

        $this->call([
            BrandSeeder::class,          // 1. Creates all Brands
            CategorySeeder::class,       // 2. Creates all Categories
            AttributeSeeder::class,      // 3. Creates all Attribute definitions
            CategoryAttributeSeeder::class, // 4. Links Attributes to Categories (depends on 2 & 3)
            ProductSeeder::class,        // 5. Creates Products and their ProductAttributeValues (depends on 1, 2, & 3)
            // ReviewSeeder::class,      // etc., if you have it
        ]);

        $this->command->info('========== Main Database Seeder Completed ==========');
        $this->command->info('====================================================');
        Log::channel('stderr')->info('DatabaseSeeder: --- ALL SEEDERS COMPLETED ---');
    }
}
