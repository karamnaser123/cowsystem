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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cownumber');
            $table->string('doctor')->nullable();
            $table->date('identifydate')->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->date('nextfollowupdate')->nullable();
            $table->string('typeofmedication')->nullable();
            $table->string('numberofdoses')->nullable();
            $table->foreign('cownumber')->references('id')->on('cows');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
