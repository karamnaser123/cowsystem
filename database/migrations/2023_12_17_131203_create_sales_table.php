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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerid');
            $table->unsignedBigInteger('products_id');
            $table->string('productquantity');
            $table->float('totalprice');
            $table->float('discount')->nullable();
            $table->unsignedBigInteger('payment_id');
            $table->string('bankname')->nullable();
            $table->string('checknumber')->nullable();
            $table->date('exchangedate')->nullable();
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('customerid')->references('id')->on('customers');
            $table->foreign('payment_id')->references('id')->on('paymentmethods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
