<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Эта функция описывает, как СОЗДАТЬ таблицу `reviews`.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Связь с продуктом, о котором отзыв
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Связь с пользователем, который оставил отзыв
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Имя автора (на случай, если пользователь удалит аккаунт или отзыв анонимный)
            // Это поле может быть полезным, но не обязательным. Если у вас его нет, можно убрать.
            $table->string('author_name')->nullable();

            // Оценка от 1 до 5
            $table->unsignedTinyInteger('rating')->default(5);

            // Текст отзыва
            $table->text('comment');

            // === ВАЖНАЯ КОЛОНКА ДЛЯ МОДЕРАЦИИ ===
            // Она будет хранить 0 (false) или 1 (true).
            // По умолчанию - false, то есть отзыв скрыт до одобрения.
            $table->boolean('is_approved')->default(false);
            // =====================================

            $table->timestamps(); // Колонки created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Эта функция описывает, как УДАЛИТЬ таблицу `reviews`.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};