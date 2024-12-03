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
        Schema::create('cowbirths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cownumber')->nullable();
            $table->unsignedBigInteger('mothernumber')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('gender')->nullable();
            $table->string('note')->nullable();
            $table->foreign('cownumber')->references('id')->on('cows');
            $table->foreign('mothernumber')->references('id')->on('cows');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cowbirths');
    }
};
