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
        // Создаем сводную таблицу 'compare_product' для связи пользователей и товаров
        Schema::create('compare_product', function (Blueprint $table) {
            // ID пользователя. Связываем с таблицей 'users'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ID товара. Связываем с таблицей 'products'
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Устанавливаем первичный ключ на комбинацию user_id и product_id,
            // чтобы один и тот же товар не мог быть добавлен в сравнение дважды одним пользователем.
            $table->primary(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compare_product');
    }
};