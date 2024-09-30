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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->string('description',1000);
            $table->float('price');
            $table->float('priceBeforeDiscount')->default(0);
            $table->string('image')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('authors');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->integer('numberOfPurchased')->default(0);
            $table->integer('stock')->default(100);
            $table->integer('discount')->default(0);
            $table->decimal('avgRating',4,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
