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
        Schema::create('ordertodistributors', function (Blueprint $table) {
            $table->id();
            $table->string('invoicenumber');
            $table->string('invoicedate');
            $table->string('distributorname');
            $table->string('contactno');
            $table->string('email');
            $table->string('address');
            $table->string('region');
            $table->string('productname');  
            $table->string('productqty');
            $table->string('gstrate');
            $table->string('selectgstrate');
            $table->string('rate');
            $table->string('amount');
            $table->string('sgst');
            $table->string('cgst');
            $table->string('igst');
            $table->string('status');
            $table->string('distributorid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordertodistributors');
    }
};
