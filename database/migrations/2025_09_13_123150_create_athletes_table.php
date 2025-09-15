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
        Schema::create('athletes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sports_id')->unique();           // idrettens-id
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->enum('gender', ['M','F','X']);
            $table->uuid('club_id');
            $table->string('nationality', 3)->nullable();    // ISO3
            $table->string('status', 20)->default('active');
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs')->restrictOnDelete();
            $table->index(['last_name', 'dob']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
