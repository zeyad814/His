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
            $table->date('date')->nullable(); // تاريخ تسجيل الزيارة في السيستم
            $table->date('visit_date')->nullable();  // تاريخ الزيارة الفعلي
            $table->string('dental')->nullable(); // فحص الأسنان أثناء الحمل
            $table->string('vitamins')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->text('complications')->nullable();  // المضاعفات
            $table->string('blood_pressure')->nullable();
            $table->text('general_exam')->nullable(); // الفحص العام
            $table->text('health_education')->nullable(); // التثقيف الصحي
            $table->date('next_visit')->nullable();
            $table->text('obstetric_assessment')->nullable();  // التقييم التوليدي
            $table->string('ultrasound')->nullable(); // الموجات فوق الصوتية (U/S)
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
