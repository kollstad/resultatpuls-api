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
        Schema::create('disciplines', function (Blueprint $table) {
             $table->string('code', 16)->primary(); // f.eks '100m','LJ','MAR','24H'
            $table->string('name');
            $table->enum('type', ['track','field','road','xc','trail','multi','relay']);
            $table->enum('unit', ['s','m','km']);
            $table->boolean('has_wind')->default(false);
            $table->boolean('is_relay')->default(false);
            $table->string('default_implement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
