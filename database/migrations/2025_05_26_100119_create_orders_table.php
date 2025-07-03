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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('address_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->enum('shipping_status', ['pending', 'confirmed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['draft', 'waiting_payment', 'paid', 'shipped', 'completed', 'cancelled'])->default('draft');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
