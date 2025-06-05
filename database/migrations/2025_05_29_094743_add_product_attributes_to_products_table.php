<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Добавляем колонки, если их нет. Укажите правильные типы данных.
            // Для простоты добавляем в конец таблицы.
            if (!Schema::hasColumn('products', 'screen_size')) {
                $table->string('screen_size')->nullable(); // Например, "15.6", "27"
            }
            if (!Schema::hasColumn('products', 'resolution')) {
                $table->string('resolution')->nullable(); // Например, "1920x1080"
            }
            if (!Schema::hasColumn('products', 'matrix_type')) {
                $table->string('matrix_type')->nullable(); // Например, "IPS", "VA"
            }
            if (!Schema::hasColumn('products', 'refresh_rate')) {
                $table->integer('refresh_rate')->unsigned()->nullable(); // Например, 60, 144
            }
            if (!Schema::hasColumn('products', 'response_time')) {
                $table->integer('response_time')->unsigned()->nullable(); // Например, 1, 5
            }
            if (!Schema::hasColumn('products', 'ram_size')) {
                $table->string('ram_size')->nullable(); // Например, "8 ГБ", "16" (если храните как строку или число)
            }
            if (!Schema::hasColumn('products', 'cpu_type')) {
                $table->string('cpu_type')->nullable();
            }
            if (!Schema::hasColumn('products', 'ssd_volume')) {
                $table->string('ssd_volume')->nullable(); // Например, "256 ГБ", "1 ТБ"
            }
            if (!Schema::hasColumn('products', 'os_type')) {
                $table->string('os_type')->nullable();
            }
            if (!Schema::hasColumn('products', 'appliance_type')) {
                $table->string('appliance_type')->nullable();
            }
            if (!Schema::hasColumn('products', 'chair_material')) {
                $table->string('chair_material')->nullable();
            }
            if (!Schema::hasColumn('products', 'chair_mechanism')) {
                $table->string('chair_mechanism')->nullable();
            }
            if (!Schema::hasColumn('products', 'table_adjustment')) {
                $table->string('table_adjustment')->nullable(); // Или boolean, если только да/нет
            }
            if (!Schema::hasColumn('products', 'network_device_type')) {
                $table->string('network_device_type')->nullable();
            }
            if (!Schema::hasColumn('products', 'security_system_type')) {
                $table->string('security_system_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columnsToDrop = [
                'screen_size', 'resolution', 'matrix_type', 'refresh_rate', 'response_time',
                'ram_size', 'cpu_type', 'ssd_volume', 'os_type', 'appliance_type',
                'chair_material', 'chair_mechanism', 'table_adjustment',
                'network_device_type', 'security_system_type'
            ];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};