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
        Schema::create('userhierarchytabs', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('contactno');
            $table->string('email');
            $table->string('address');
            $table->string('region');
            $table->string('tehsils');
            $table->string('file');
            $table->string('framname')->nullable();
            $table->string('roleid');
            $table->string('rgid')->nullable();
            $table->string('insertdate');
            $table->string('postalcode');
            $table->string('gstcode');
            $table->string('pincode');
            $table->string('assignid');
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
        Schema::dropIfExists('userhierarchytabs');
    }
};
