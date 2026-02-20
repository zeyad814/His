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
        Schema::create('cv_risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('cascade');

            $table->date('assessment_date');
            $table->boolean('hypertension')->default(false);
            $table->boolean('dm')->default(false);
            $table->boolean('obesity')->default(false);
            $table->boolean('smoking')->default(false);
            $table->boolean('family_history_cardiac')->default(false);
            
            // المرحلة الثانية: Measurements & Labs
            $table->string('bp')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('cholesterol_total', 6, 2)->nullable();
            $table->decimal('ldl_level', 6, 2)->nullable();
            
            // المرحلة الثالثة: Assessment & Management
            $table->string('cv_risk_level')->nullable();
            $table->text('management_plan')->nullable();
            $table->string('referral_to')->nullable();
            $table->date('follow_up_date')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_risk_assessments');
    }
};
