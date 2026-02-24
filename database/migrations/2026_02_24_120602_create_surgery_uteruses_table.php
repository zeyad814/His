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
            $table->foreignId('family_planning_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nurse_id')->constrained()->cascadeOnDelete();

            // البيانات الطبية الأساسية من الاستمارة
            $table->text('diagnosis')->nullable(); // التشخيص
            $table->unsignedInteger('patient_age')->nullable(); // العمر

            // نوع الإجراء 
            $table->enum('procedure_type', [
                'IUD_insertion',
                'IUD_removal',
                'Implant_insertion',
                'Implant_removal'
            ])->nullable();

            // 1. التحقق قبل الإجراء (Pre-procedure Check)
            $table->boolean('patient_identity_verified')->default(false); // التأكد من هوية المريضة
            $table->boolean('informed_consent_signed')->default(false);  // إقرار الموافقة المستنيرة
            $table->string('site_side')->nullable(); // جهة الإجراء (يمين/يسار/لا ينطبق)
            $table->boolean('procedure_site_marked')->default(false); // تعليم مكان الجراحة (لو لازم)

            // 2. التحقق من التجهيزات
            $table->boolean('equipment_sterilization_verified')->default(false); // التأكد من تعقيم الآلات
            $table->boolean('supplies_availability_verified')->default(false);   // توافر الغيارات والمستهلكات

            // 3. الفحوصات (موجودة في الاستمارة)
            $table->boolean('pregnancy_test_done')->nullable();
            $table->boolean('hemoglobin_test_done')->nullable();

            // 4. فقرة الـ "Time Out" (لحظة ما قبل البدء مباشرة)
            $table->boolean('final_team_verification')->default(false); // تعريف الفريق الطبي ببعضه والتأكد الأخير

            // التاريخ والوقت
            $table->date('procedure_date')->nullable();
            $table->time('procedure_time')->nullable();

           
            $table->timestamps();
            $table->softDeletes();
           
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
