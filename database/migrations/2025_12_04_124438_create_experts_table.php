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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('job_en');
            $table->string('job_ar');
            $table->string('medpulse_role_en');
            $table->string('medpulse_role_ar');
            $table->text('medpulse_role_description_en');
            $table->text('medpulse_role_description_ar');
            $table->string('current_job_en');
            $table->string('current_job_ar');
            $table->string('coverage_type_en');
            $table->string('coverage_type_ar');
            $table->json('evaluated_specialties_en')->nullable();
            $table->json('evaluated_specialties_ar')->nullable();
            $table->integer('number_of_events')->default(0);
            $table->text('description_en');
            $table->text('description_ar');
            $table->integer('years_of_experience')->default(0);
            $table->json('subspecialities_en')->nullable();
            $table->json('membership_en')->nullable();
            $table->json('subspecialities_ar')->nullable();
            $table->json('membership_ar')->nullable();
            $table->timestamps();
            // $table->foreignId('role_id')
            // ->nullable()
            // ->after('id')
            // ->constrained('role')
            // ->onDelete('set null');
        });
    }
        
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};
