<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Make sure the class name matches your filename, e.g., CreateProductAttributeValuesTable
return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');

            // Value columns - ensure these match what your model's mutator handles
            $table->text('text_value')->nullable();
            $table->integer('integer_value')->nullable();
            $table->decimal('decimal_value', 10, 2)->nullable(); // Adjust precision as needed
            $table->boolean('boolean_value')->nullable();
            $table->date('date_value')->nullable();           // Added this line
            $table->dateTime('datetime_value')->nullable();

            $table->timestamps();

            // A product should have a specific attribute only once
            $table->unique(['product_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};