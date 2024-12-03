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
        Schema::create('milks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cownumber');
            $table->date('date')->nullable();
            $table->float('morningamount')->nullable();
            $table->float('noonamount')->nullable();
            $table->float('afternoonamount')->nullable();
            $table->date('dryingdate')->nullable();
            $table->foreign('cownumber')->references('id')->on('cows');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milks');
    }
};
