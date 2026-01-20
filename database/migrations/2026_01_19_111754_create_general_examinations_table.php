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
        Schema::create('general_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('physical_examination_id')->constrained()->cascadeOnDelete();

            $table->string('blood_pressure')->nullable(); // ضغط الدم
            $table->string('pulse')->nullable(); // النبض
            $table->string('temperature')->nullable(); // درجة الحرارة
            $table->string('respiratory_rate')->nullable(); // معدل التنفس

            $table->string('height')->nullable(); // الطول
            $table->string('weight')->nullable(); // الوزن
            $table->string('bmi')->nullable(); // مؤشر كتلة الجسم

            $table->text('skin_complexion')->nullable(); // الجلد ولون البشرة
            $table->text('general_appearance')->nullable(); // المظهر العام

            $table->text('upper_limb')->nullable(); // الطرف العلوي
            $table->text('lower_limb')->nullable(); // الطرف السفلي

            $table->text('pain_assessment')->nullable(); // تقييم الألم
            $table->text('disabilities')->nullable(); // الإعاقات
            $table->text('deformities')->nullable(); // التشوهات

            $table->text('abdomen')->nullable(); // البطن
            $table->text('head_neck')->nullable(); // الرأس والرقبة
            $table->text('heart')->nullable(); // القلب
            $table->text('chest')->nullable(); // الصدر
            $table->text('neurological')->nullable(); // الجهاز العصبي
            $table->text('eyes')->nullable(); // العين
            $table->text('ent')->nullable(); // الأنف والأذن والحنجرة

            $table->text('nutritional_assessment')->nullable(); // التقييم الغذائي
            $table->text('risk_factors')->nullable(); // عوامل الخطورة
            $table->text('conclusion')->nullable(); // الخلاصة الطبية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_examinations');
    }
};
