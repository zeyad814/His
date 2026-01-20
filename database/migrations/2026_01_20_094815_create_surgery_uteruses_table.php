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
        Schema::create('surgery_uteruses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('nurse_id')->constrained()->cascadeOnDelete(); 

            // التحقق قبل العملية (Checklist)
            $table->boolean('correct_procedure_verified')->nullable(); // تم التأكد من الإجراء الصحيح
            $table->string('procedure_type')->nullable();              // نوع العملية
            $table->string('site_side')->nullable();                    // جهة العملية (يمين / يسار)
            $table->boolean('correct_site_verified')->nullable();       // تم التأكد من موضع العملية
            $table->boolean('correct_patient_verified')->nullable();    // تم التأكد من هوية المريضة
            $table->boolean('site_marked')->nullable();                 // تم تعليم مكان الجراحة

            // التاريخ والوقت
            $table->date('procedure_date')->nullable(); // تاريخ العملية
            $table->time('procedure_time')->nullable(); // وقت العملية

            // الفحوصات والتحاليل
            $table->boolean('hemoglobin_test_done')->nullable(); // تحليل الهيموجلوبين
            $table->boolean('pregnancy_test_done')->nullable();  // اختبار الحمل
            $table->boolean('labs_completed')->nullable();        // اكتمال التحاليل

            // البيانات الطبية
            $table->text('diagnosis')->nullable();                // التشخيص
            $table->unsignedInteger('patient_age')->nullable();   // عمر المريضة
            $table->boolean('medical_exam_done')->nullable();     // تم الفحص الطبي
            $table->boolean('medical_assessment_done')->nullable(); // تم التقييم الطبي

            // تجهيز مكان العملية
            $table->boolean('site_cleaned')->nullable();           // تم تنظيف مكان الجراحة
            $table->boolean('site_identified')->nullable();        // تم تحديد مكان الجراحة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgery_uteruses');
    }
};
