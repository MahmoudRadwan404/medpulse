<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->string('location');
            $table->date('date_of_happening');
            $table->integer('stars')->default(0);
            $table->float('rate')->default(0);
            $table->string('organizer_en');
            $table->string('organizer_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->json('subjects_description_en')->nullable();
            $table->json('subjects_description_ar')->nullable();
            $table->json('subjects_en')->nullable();
            $table->json('subjects_ar')->nullable();
            $table->text('authors_description_en');
            $table->text('authors_description_ar');
            $table->text('comments_for_medpulse_en');
            $table->text('comments_for_medpulse_ar');
            $table->timestamps();
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