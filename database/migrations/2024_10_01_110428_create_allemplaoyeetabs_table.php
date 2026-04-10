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
        Schema::create('allemplaoyeetabs', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('distributername');
            $table->string('contactno');
            $table->string('email');
            $table->string('address');
            $table->string('product');
            $table->string('quantity');
            $table->string('region');
            $table->string('file');
            $table->string('companyname');
            $table->string('role');
            $table->string('insertdate');
            $table->string('postalcode');
            $table->string('gstcode');
            $table->string('pincode');
            $table->string('city');
            $table->string('state');
            $table->string('bankname');
            $table->string('accountnum');
            $table->string('ifsccode');
            $table->string('holdername');
            $table->string('accounttype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allemplaoyeetabs');
    }
};
