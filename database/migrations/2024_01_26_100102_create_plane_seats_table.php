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
        Schema::create('plane_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plane_id');
            $table->foreign('plane_id')->references('id')->on('planes')->onDelete('cascade');
            $table->integer('seat_number');
            $table->string('class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plane_seats');
    }
};
