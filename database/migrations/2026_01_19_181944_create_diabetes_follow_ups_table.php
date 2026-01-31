<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diabetes_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained('visits')->cascadeOnDelete(); // مهم للربط بالزيارة

            // الخطوة 1: البيانات الأساسية والقياسات
            $table->date('date');
            $table->text('chief_complaint')->nullable();
            // القياس الحيوي الأساسي في السكر هو الـ BMI (خرجناه أعمدة)
            // $table->decimal('bmi', 5, 2)->nullable();

            // الخطوة 2: المخاطر والمضاعفات (JSON عشان الـ Checkboxes في Figma)
            $table->json('risk_factors')->nullable();
            $table->json('complications')->nullable();

            // الخطوة 3: التحاليل (Workup) مقسمة حسب الصور
            $table->json('workup_every_visit')->nullable(); // FBS, Urine analysis
            $table->json('workup_6_month')->nullable();     // HbA1c, Creatinine-eGFR
            $table->json('workup_annual')->nullable();      // Fundus, Foot, ECG, Lipids...

            // الخطوة 4: العلاج والتثقيف
            $table->json('health_education')->nullable();
            $table->text('referrals')->nullable();
            $table->text('treatment_plan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diabetes_follow_ups');
    }
};
