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

            // العلامات الحيوية والقياسات
            $table->string('blood_pressure')->nullable();
            $table->string('pulse')->nullable();
            $table->string('temperature')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bmi')->nullable();

            // الحقول التي تم تحويلها لـ JSON (بناءً على صور Figma)
            $table->json('skin_complexion')->nullable(); // يحتوي على (Jaundice, Cyanosis, Pallor, bruises, etc.)
            $table->json('head_neck')->nullable();       // يحتوي على (Jaundice, Sutures, Fontanels, Other)
            $table->json('heart')->nullable();           // يحتوي على (Heart sounds, Murmurs, Other)
            $table->json('chest')->nullable();           // يحتوي على (Expansion, Breathing sounds, Breast mass, etc.)
            $table->json('abdomen')->nullable();         // يحتوي على (Liver, Spleen, Kidneys, Ascites, etc.)
            $table->json('neurological')->nullable();    // يحتوي على (Motor, Sensory systems)
            $table->json('upper_limb')->nullable();
            $table->json('lower_limb')->nullable();
            $table->json('disabilities')->nullable();
            $table->json('eyes')->nullable();            // جدول العيون (R, L, Result, Comment)
            $table->json('ent')->nullable();             // جدول الأنف والأذن (Hearing, Nose, Throat)
            $table->json('risk_factors')->nullable();    // قائمة عوامل الخطورة (Smoking, DM, Obesity, etc.)
            $table->json('lab_results')->nullable();

            // حقول نصية للوصف والتقييم
            $table->text('general_appearance')->nullable();
            $table->text('pain_assessment')->nullable();
            $table->text('deformities')->nullable();
            $table->text('nutritional_assessment')->nullable();
            $table->text('conclusion')->nullable();

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
