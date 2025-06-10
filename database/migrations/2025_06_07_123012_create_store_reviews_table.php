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
        // Эта функция создает таблицу 'store_reviews' в вашей базе данных
        Schema::create('store_reviews', function (Blueprint $table) {
            $table->id(); // Поле для ID
            
            // Связь с таблицей пользователей. Может быть пустым, если отзыв от гостя.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Поле для имени автора отзыва (обязательное)
            $table->string('name');
            
            // Поле для текста отзыва
            $table->text('text');
            
            // Поле для рейтинга (от 1 до 5)
            $table->unsignedTinyInteger('rating');
            
            // Поле для модерации (по умолчанию отзыв одобрен)
            $table->boolean('is_approved')->default(true);
            
            // Поля для даты создания и обновления
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_reviews');
    }
};