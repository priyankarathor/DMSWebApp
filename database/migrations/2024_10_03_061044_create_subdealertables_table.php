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
        Schema::create('subdealertables', function (Blueprint $table) {
            $table->id();
            $table->string('dealerid');
            $table->string('username');
            $table->string('contactno');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('quantity')->nullable();
            $table->string('region')->nullable();
            $table->string('file')->nullable();
            $table->string('companyname')->nullable();
            $table->string('role');
            $table->string('insertdate')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('gstcode')->nullable();
            $table->string('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('bankname')->nullable();
            $table->string('accountnum')->nullable();
            $table->string('ifsccode')->nullable();
            $table->string('holdername')->nullable();
            $table->string('accounttype')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdealertables');
    }
};
