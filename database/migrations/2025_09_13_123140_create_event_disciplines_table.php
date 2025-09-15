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
        Schema::create('event_disciplines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('event_id');
            $table->string('discipline_code', 16);
            $table->string('age_category', 16)->nullable(); // U18/U20/Senior/Masters
            $table->string('round', 16)->nullable();        // heat/semifinale/finale
            $table->enum('timing_method', ['hand','auto','chip'])->nullable();
            $table->decimal('implement_weight', 4, 1)->nullable();
            $table->boolean('is_team_scored')->default(false);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->foreign('discipline_code')->references('code')->on('disciplines')->restrictOnDelete();
            $table->index(['event_id','discipline_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_disciplines');
    }
};
