<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('seller_id');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade'); // <- Tambahan ini
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('category')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
