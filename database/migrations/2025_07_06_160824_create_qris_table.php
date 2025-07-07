<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('qris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->text('qris_content');
            $table->timestamp('qris_request_date');
            $table->string('qris_invoiceid');
            $table->string('qris_invoicestatus');
            $table->integer('qris_invoiceamount');


            // Menambahkan foreign key constraint jika diperlukan
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qris');
    }
};
