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
        Schema::table('qris', function (Blueprint $table) {
            //
            $table->integer('qris_invoiceamount')->nullable();
            $table->string('qris_invoicestatus')->default('unpaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qris', function (Blueprint $table) {
            //
            $table->dropColumn('qris_invoiceamount');
            $table->dropColumn('qris_invoicestatus');
        });
    }
};
