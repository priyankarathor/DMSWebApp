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
        Schema::create('productadmintabs', function (Blueprint $table) {
            $table->id();
            $table->string('productname');
            $table->string('description');
            $table->string('productprice');
            $table->string('category');
            $table->string('file');
            $table->string('image');
            $table->string('quantity');
            $table->string('weightnum');
            $table->string('weihgtclass'); 
            $table->string('hsncode'); 
            $table->string('link');
            $table->string('metatag');
            $table->string('metakeyword');
            $table->string('metadescription');
            $table->string('Action');
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productadmintabs');
    }
};
