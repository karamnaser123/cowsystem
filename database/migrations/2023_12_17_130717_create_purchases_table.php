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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplierid');
            $table->string('productname');
            $table->float('purchasingprice');
            $table->integer('productquantity');
            $table->float('totalprice');
            $table->unsignedBigInteger('payment_id');
            $table->string('bankname')->nullable();
            $table->string('checknumber')->nullable();
            $table->date('exchangedate')->nullable();
            $table->foreign('supplierid')->references('id')->on('suppliers');
            $table->foreign('payment_id')->references('id')->on('paymentmethods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
