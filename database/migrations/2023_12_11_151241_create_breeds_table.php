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
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cownumber');
            $table->date('breedingdate')->nullable();
            $table->string('breedingtype')->nullable();
            $table->string('breedingstatus')->nullable();
            $table->date('examinationdate')->nullable();
            $table->string('result')->nullable();
            $table->date('pregnancyhistory')->nullable();
            $table->string('note')->nullable();
            $table->date('expectedbirthdate')->nullable();
            $table->float('cost')->nullable();
            $table->string('pollinationby')->nullable();
            $table->foreign('cownumber')->references('id')->on('cows');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeds');
    }
};
