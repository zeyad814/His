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
        Schema::create('pregnancy_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnancy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            //Date
            $table->date('visit_date')->nullable(); /// تاريخ الزيارة الفعلي
            $table->date('next_visit')->nullable();  // موعد الزيارة القادمة

            //الفحص العام
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->text('general_exam')->nullable();

            // التقييم التوليدي (Obstetric Assessment)
            $table->string('fundal_height')->nullable();      // Fundal Level (ارتفاع الرحم)
            $table->string('fetal_lie')->nullable();          // Fetal Lie (وضع الجنين)
            $table->string('fetal_heart_rate')->nullable();   // Fetal Heart Sound (نبض الجنين)
            $table->string('fetal_movement')->nullable();     // Fetal Movement (حركة الجنين)
            $table->string('ultrasound')->nullable();         // U/S ملاحظات السونار

            // التحاليل في الزيارة (Labs)
            $table->string('urine_analysis')->nullable();     // زلال / سكر
            $table->decimal('hemoglobin', 5, 2)->nullable();  // نسبة الهيموجلوبين
            $table->decimal('blood_glucose', 5, 2)->nullable(); // سكر الدم العشوائي

            // التثقيف والعلاج
            $table->string('dental')->nullable(); // فحص الأسنان أثناء الحمل
            $table->string('vitamins')->nullable();
            $table->text('health_education')->nullable(); // التثقيف الصحي
            $table->text('complications')->nullable();  // المضاعفات

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancy_visits');
    }
};
