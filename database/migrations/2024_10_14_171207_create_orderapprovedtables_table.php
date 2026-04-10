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
        Schema::create('orderapprovedtables', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceno');
            $table->string('invoicedate');
            $table->string('framname');
            $table->string('gstnumber');
            $table->string('username');
            $table->string('contactno');
            $table->string('email');
            $table->string('region');
            $table->string('address');
            $table->string('userrole');
            $table->string('productname');
            $table->string('productquantity');
            $table->string('productbulk');
            $table->string('amount');
            $table->string('totalamount');
            $table->string('gstrate');
            $table->string('selectgst');
            $table->string('sgst')->nullable();
            $table->string('cgst')->nullable();
            $table->string('igst')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderapprovedtables');
    }
};
