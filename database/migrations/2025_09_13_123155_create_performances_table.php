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
        Schema::create('performances', function (Blueprint $table) {
             $table->uuid('id')->primary();
                $table->uuid('event_discipline_id');
                $table->uuid('athlete_id')->nullable();     // enten individ...
                $table->uuid('relay_team_id')->nullable();  // ...eller stafett senere
                $table->bigInteger('mark_raw');             // normalisert (ms, mm, etc.)
                $table->string('mark_display', 24);         // visningsformat
                $table->enum('unit', ['s','m','km']);
                $table->integer('position')->nullable();
                $table->decimal('wind', 3, 1)->nullable();  // m/s
                $table->enum('status', ['OK','DQ','DNF','DNS','NM'])->default('OK');
                $table->boolean('is_legal')->default(true);
                $table->jsonb('splits_json')->nullable();
                $table->jsonb('device_meta_json')->nullable();
                $table->uuid('version_group_id');           // for revisjoner
                $table->boolean('is_current')->default(true);
                $table->uuid('submitted_by')->nullable();
                $table->timestampTz('submitted_at')->nullable();
                $table->string('signature_id')->nullable();
                $table->string('hash', 64)->nullable();
                $table->timestamps();

                $table->foreign('event_discipline_id')->references('id')->on('event_disciplines')->cascadeOnDelete();
                $table->foreign('athlete_id')->references('id')->on('athletes')->restrictOnDelete();

                $table->index(['event_discipline_id','is_current']);
                $table->index(['athlete_id','is_current']);
                $table->index(['version_group_id','is_current']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
