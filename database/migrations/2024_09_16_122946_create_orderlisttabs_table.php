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
        Schema::create('orderlisttabs', function (Blueprint $table) {
            $table->id();
            $table->string('productname');
            $table->string('productquantity');
            $table->string('productdeliveryadd');
            $table->string('productexpected');
            $table->string('userid');
            $table->string('userregisterid');
            $table->string('username');
            $table->string('useremail');
            $table->string('userphone');
            $table->string('userrole');
            $table->string('productbulk');
            $table->string('orderstatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderlisttabs');
    }
};
