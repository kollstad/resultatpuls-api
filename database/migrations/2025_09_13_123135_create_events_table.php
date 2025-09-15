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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', ['indoor','outdoor','road','xc','trail']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('city')->nullable();
            $table->string('venue')->nullable();
            $table->string('sanction_level', 32)->nullable();
            $table->string('course_cert', 32)->nullable();     // AIMS etc.
            $table->integer('elevation_gain')->nullable();     // trail
            $table->timestamps();
            $table->index(['type','start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
