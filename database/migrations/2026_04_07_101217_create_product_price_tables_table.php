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
        Schema::create('product_price_tables', function (Blueprint $table) {
            $table->id();
            $table->String('pid');
            $table->String('state');
            $table->String('pricecndf');
            $table->String('pricedistributor');
            $table->string('pricedealer');
            $table->string('pricesubdealer');
            $table->string('priceretialer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_tables');
    }
};
