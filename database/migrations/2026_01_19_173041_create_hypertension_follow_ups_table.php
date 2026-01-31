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
        Schema::create('hypertension_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained('visits')->cascadeOnDelete();

            // الخطوة الأولى: التاريخ والشكوى والضغط
            $table->date('date');
            $table->text('chief_complaint')->nullable();
            $table->integer('bp_systolic')->nullable();
            $table->integer('bp_diastolic')->nullable();
            // $table->json('bp')->nullable(); // هيشيل الـ bp_systolic و bp_diastolic

            // الخطوة الثانية: عوامل الخطورة وتأثر الأعضاء
            $table->json('risk_factors')->nullable();
            $table->json('complications_and_target_organ_affection')->nullable(); // JSON كما طلبت

            // الخطوة الثالثة: الفحوصات (6 شهور وسنوية)
            $table->json('workup_6_month')->nullable();
            $table->json('workup_annual')->nullable();

            // الخطوة الرابعة: التثقيف والعلاج
            $table->json('health_education')->nullable(); // تحول إلى JSON
            $table->text('treatment_plan')->nullable();    // تحول إلى Text

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hypertension_follow_ups');
    }
};
