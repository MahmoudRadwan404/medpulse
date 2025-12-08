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
        Schema::create('event_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained()->onDelete('cascade');
            $table->text('description_en');
            $table->text('description_ar');
            $table->float('content_rate')->default(0);
            $table->text('content_rate_description_en');
            $table->text('content_rate_description_ar');
            $table->float('organisation_rate')->default(0);
            $table->text('organisation_rate_description_en');
            $table->text('organisation_rate_description_ar');
            $table->float('speaker_rate')->default(0);
            $table->text('speaker_rate_description_en');
            $table->text('speaker_rate_description_ar');
            $table->float('sponsering_rate')->default(0);
            $table->text('sponsering_rate_description_en');
            $table->text('sponsering_rate_description_ar');
            $table->float('scientific_impact_rate')->default(0);
            $table->text('scientific_impact_rate_description_en');
            $table->text('scientific_impact_rate_description_ar');
            $table->float('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_analyses');
    }
};
