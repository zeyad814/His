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
        Schema::create('psychological_support_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->date('visit_date');
            $table->string('questionnaire_type')->nullable();
            $table->text('visit_reason');
            $table->string('questionnaire_result');
            $table->text('initial_diagnosis');
            $table->text('treatment_plan');
            $table->string('referral_location')->nullable();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychological_support_visits');
    }
};
