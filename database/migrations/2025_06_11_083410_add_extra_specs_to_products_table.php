<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Добавляем новые колонки. Laravel разместит их в конце таблицы.
            // Это самый надежный способ, чтобы избежать ошибок с "after()".
            $table->string('color')->nullable();
            $table->decimal('weight', 8, 2)->nullable(); // Вес, например 1.85 кг
            $table->string('os')->nullable(); // Операционная система
            $table->string('screen_resolution')->nullable();
            $table->string('screen_matrix')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('battery_capacity')->nullable();
            $table->string('material')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // При откате миграции удаляем добавленные колонки.
            // Этот блок написан правильно и не требует изменений.
            $table->dropColumn([
                'color',
                'weight',
                'os',
                'screen_resolution',
                'screen_matrix',
                'dimensions',
                'battery_capacity',
                'material'
            ]);
        });
    }
};