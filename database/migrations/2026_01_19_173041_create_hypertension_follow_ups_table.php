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
            $table->date('date'); // تاريخ المتابعة
            $table->text('health_education')->nullable(); // التثقيف الصحي
            $table->text('treatment_plan')->nullable(); // الخطة العلاجية
            $table->text('chief_complaint')->nullable(); // الشكوى الرئيسية
            $table->string('bp')->nullable(); // ضغط الدم
            $table->text('risk_factors')->nullable(); // عوامل الخطورة
            $table->text('target_organ_affection')->nullable(); // تأثر الأعضاء المستهدفة
            $table->text('workup_6_month')->nullable(); // فحوصات كل 6 شهور
            $table->text('workup_annual')->nullable(); // فحوصات سنوية 
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
