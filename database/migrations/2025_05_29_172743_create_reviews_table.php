<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_reviews_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Другие поля для отзыва, например:
            $table->unsignedBigInteger('user_id')->nullable(); // Если отзывы от зарегистрированных пользователей
            $table->string('user_name')->nullable();        // Или имя для анонимных
            $table->text('comment');
            $table->unsignedTinyInteger('rating')->nullable(); // Рейтинг от 1 до 5, например

            // ВНЕШНИЙ КЛЮЧ ДЛЯ СВЯЗИ С ПРОДУКТОМ
            $table->unsignedBigInteger('product_id'); // <--- ЭТО КЛЮЧЕВАЯ КОЛОНКА
            // $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Более краткий способ Laravel

            $table->timestamps();

            // Определение внешнего ключа (если не использовали ->constrained())
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // Если user_id есть:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};