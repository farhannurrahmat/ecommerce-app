<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Foreign key ke tabel Users
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel Produk
            $table->integer('rating')->tinyInteger()->unsigned(); // Rating untuk produk
            $table->text('comment'); // Komentar
            $table->timestamps(); // Created at dan Updated at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
