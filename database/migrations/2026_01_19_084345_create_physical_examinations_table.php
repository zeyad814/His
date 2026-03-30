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
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            
            // Medical History
            $table->text('hospitalization')->nullable();
            $table->text('previous_operations')->nullable();
            $table->text('current_medication')->nullable();
            $table->text('trauma_injuries')->nullable();
            $table->boolean('has_allergy')->default(false);
            $table->boolean('has_adverse_drug_reaction')->default(false);
            $table->boolean('has_abuse_negligence')->default(false);

            // Special Habits (Checkboxes)
            $table->boolean('habit_smoking')->default(false);
            $table->boolean('habit_alcohol')->default(false);
            $table->text('habit_other')->nullable();

            // Psychiatric History (Checkboxes)
            $table->boolean('psych_irrelevant')->default(false);
            $table->boolean('psych_follow_up')->default(false);
            $table->boolean('psych_medical_treatment')->default(false);
            $table->text('psych_other')->nullable();

            // Family History (JSON is best here for the long list)
            $table->json('family_diseases')->nullable(); // لتخزين مصفوفة الأمراض المختارة
            $table->text('family_history_other')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_examinations');
    }
};
