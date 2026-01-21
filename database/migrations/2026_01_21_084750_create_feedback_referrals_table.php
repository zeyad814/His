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
        Schema::create('feedback_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->text('other_interventions')->nullable(); // تدخلات طبية أخرى تمت
            $table->date('revisit_date')->nullable(); // تاريخ إعادة الزيارة
            $table->dateTime('arrival_date_time')->nullable(); // تاريخ ووقت وصول المريض
            $table->string('sick_leave')->nullable(); // إجازة مرضية (نعم / لا / المدة)
            $table->text('exam_findings')->nullable(); // نتائج الفحص
            $table->text('follow_up_instructions')->nullable(); // تعليمات المتابعة
            $table->text('investigations')->nullable(); // الفحوصات / التحاليل
            $table->string('final_diagnoses')->nullable(); // التشخيص النهائي
            $table->text('current_medications')->nullable(); // الأدوية الحالية
            $table->string('admission_ward')->nullable(); // القسم / الجناح المحجوز به
            $table->string('surgery_type')->nullable(); // نوع الجراحة (إن وجدت)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_referrals');
    }
};
