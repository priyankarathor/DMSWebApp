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
        Schema::create('manageaccounttables', function (Blueprint $table) {
            $table->id();
            $table->string('ragisternum');
            $table->string('name');
            $table->string('email');
            $table->string('role');
            $table->string('password');
            $table->string('distributer');
            $table->string('dealer');
            $table->string('subdealer');
            $table->string('retailer');
            $table->string('employee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manageaccounttables');
    }
};
