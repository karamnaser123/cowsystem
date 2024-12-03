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
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string('cownumber')->unique();
            $table->string('mothernumber')->nullable();
            $table->date('farmentrydate')->nullable();
            $table->float('weight')->nullable();
            $table->float('purchasingprice')->nullable();
            $table->float('expectedsaleprice')->nullable();
            $table->float('dailyexpense')->nullable();
            $table->string('status');
            $table->string('image')->default('cowd.png');
            $table->date('weaningdate')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('qrcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cows');
    }
};
