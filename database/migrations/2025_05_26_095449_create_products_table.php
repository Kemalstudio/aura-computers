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
    { // Открыта скобка метода up()
        Schema::create('products', function (Blueprint $table) { // Открыта скобка анонимной функции
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();

            $table->integer('quantity')->default(0);
            $table->string('sku')->nullable()->unique();
            $table->string('barcode')->nullable()->unique();

            $table->boolean('is_visible')->default(true);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('on_sale')->default(false);

            $table->string('thumbnail_url')->nullable();
            $table->json('images')->nullable();

            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->float('screen_size')->nullable();
            $table->string('resolution')->nullable();
            $table->string('matrix_type')->nullable();
            $table->integer('refresh_rate')->nullable();
            $table->integer('response_time')->nullable();
            $table->integer('ram_size')->nullable();
            $table->string('cpu_type')->nullable();
            $table->integer('ssd_volume')->nullable();
            $table->string('gpu_type')->nullable();
            $table->string('os_type')->nullable();

            $table->string('appliance_type')->nullable();
            $table->string('chair_material')->nullable();
            $table->string('chair_mechanism')->nullable();
            $table->string('table_adjustment')->nullable();
            $table->string('network_device_type')->nullable();
            $table->string('security_system_type')->nullable();
            $table->json('specifications')->nullable();

            $table->timestamps();
        }); // Закрыта скобка анонимной функции
    } // <--- ВОТ ЭТА ЗАКРЫВАЮЩАЯ СКОБКА ДЛЯ МЕТОДА up() БЫЛА ПРОПУЩЕНА

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { // Открыта скобка метода down()
        Schema::dropIfExists('products');
    } // Закрыта скобка метода down()
}; // Закрыта скобка класса