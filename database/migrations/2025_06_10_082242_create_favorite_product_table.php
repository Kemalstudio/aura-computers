<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запустить миграции.
     */
    public function up(): void
    {
        Schema::create('favorite_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();

            // Уникальный ключ, чтобы один и тот же товар нельзя было добавить в избранное дважды
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Откатить миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_product');
    }
};