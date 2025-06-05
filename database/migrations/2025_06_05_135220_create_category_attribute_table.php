<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');

            // Additional pivot data:
            $table->boolean('is_required')->default(false);         // <<< HERE IT IS
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_variant_defining')->default(false); // <<< AND HERE
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->unique(['category_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_attribute');
    }
};
