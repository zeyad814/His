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
        Schema::create('fall_risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outpatient_nursing_assessment_id')->constrained()->cascadeOnDelete();
            // نوع المقياس
            $table->enum('scale_type', ['morse', 'humpty_dumpty']);

            // حقول مقياس مورس (البالغين) - بنخزن الـ Score بتاع كل خانة
            $table->integer('m_history_falling')->default(0);
            $table->integer('m_secondary_diagnosis')->default(0);
            $table->integer('m_ambulatory_aid')->default(0);
            $table->integer('m_iv_therapy')->default(0);
            $table->integer('m_gait_transferring')->default(0);
            $table->integer('m_mental_status')->default(0);

            // حقول مقياس هامبتي دمبتي (الأطفال) 
            $table->integer('h_age')->default(0);
            $table->integer('h_gender')->default(0);
            $table->integer('h_diagnosis')->default(0);
            $table->integer('h_cognitive_impairment')->default(0);
            $table->integer('h_environmental_factors')->default(0);
            $table->integer('h_surgery_sedation')->default(0);
            $table->integer('h_medication_usage')->default(0);

            // النتيجة الإجمالية
            $table->integer('total_score');
            $table->string('risk_level'); // (Low Risk, High Risk, etc.)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fall_risk_assessments');
    }
};
