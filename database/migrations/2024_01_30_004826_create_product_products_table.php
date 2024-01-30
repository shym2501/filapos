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
    {
        Schema::create('product_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->nullable()->constrained('product_category')->constrained()->nullOnDelete();
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 0)->nullable();
            $table->tinyInteger('discount')->default(0);
            $table->unsignedBigInteger('unit_id')->default(0);
            $table->unsignedBigInteger('qty')->default(0);
            $table->timestamps();

            // $table->foreign('category_id')->references('id')->on('product_category')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('brand_id')->references('id')->on('product_brands')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('unit_id')->references('id')->on('product_unit')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_products');
    }
};
