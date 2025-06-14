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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            // Связь с таблицей товаров.
            // При удалении товара, связанные с ним отзывы тоже удалятся.
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Связь с пользователем (необязательно, но полезно)
            // Если отзыв может оставить только авторизованный пользователь
            // $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('name'); // Имя автора
            $table->text('text'); // Текст отзыва
            $table->unsignedTinyInteger('rating'); // Оценка от 1 до 5
            $table->boolean('is_approved')->default(false); // Прошел ли отзыв модерацию

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
};