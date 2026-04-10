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
        Schema::create('invoicetables', function (Blueprint $table) {
            $table->id();
            $table->string('invoicenum');
            $table->string('invoicedate');
            $table->string('companyname');
            $table->string('companyaddress');
            $table->string('companygsn');
            $table->string('companypan');
            $table->string('companyemail');
            $table->string('description');
            $table->string('gstrate');
            $table->string('qty');
            $table->string('sgst')->nullable();
            $table->string('cgst')->nullable();
            $table->string('igst')->nullable();
            $table->string('amount');
               $table->string('totalamount');
            $table->string('selectgst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoicetables');
    }
};
