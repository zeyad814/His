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
        Schema::create('family_plannings', function (Blueprint $table) {
            $table->id();
            // --- 1. الروابط الأساسية ---
            // بنربطها بالمريضة (patient) وبالدكتور اللي فتح الكارت
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('registration_date'); // تاريخ التسجيل في الخدمة

            // --- 2. التاريخ الإنجابي (Reproductive History) ---
            // البيانات دي بنجيبها من أول قسم في الصورة
            $table->integer('pregnancies_count')->default(0); // عدد مرات الحمل
            $table->integer('abortions_count')->default(0);   // عدد مرات الإجهاض
            $table->integer('alive_children_count')->default(0); // عدد الأبناء الأحياء
            $table->integer('oldest_child_age')->nullable();    // سن أكبر الأبناء
            $table->integer('youngest_child_age')->nullable();  // سن أصغر الأبناء
            $table->date('last_delivery_or_abortion_date')->nullable(); // تاريخ آخر ولادة أو إجهاض
            
            // الحالة الحالية (نعم/لا)
            $table->boolean('has_fever_or_discharge')->default(false); // هل هناك ارتفاع حرارة أو إفرازات؟
            $table->boolean('is_breastfeeding')->default(false);      // هل ترضعين طبيعياً؟

            // --- 3. بيانات استخدام الوسائل ---
            $table->boolean('is_using_contraception_now')->default(false); // هل تستخدم وسيلة حالياً؟
            $table->string('current_method_name')->nullable();             // نوع الوسيلة الحالية
            $table->boolean('used_contraception_before')->default(false);  // هل استخدمت وسيلة سابقاً؟
            $table->string('previous_method_name')->nullable();            // اسم آخر وسيلة استخدمتها

            // --- 4. الفحص الطبي (Pelvic Examination) ---
            // ده الجزء اللي موجود في أسفل الورقة (Inspection & Bimanual)
            $table->boolean('vaginal_scaring_or_ulcer')->default(false);
            $table->boolean('vaginal_discharge')->default(false);
            $table->boolean('prolapse')->default(false); // سقوط رحم
            $table->enum('uterus_position', ['anteverted', 'retroverted'])->nullable();
            $table->boolean('uterus_tenderness')->default(false); // وجع عند الفحص
            $table->enum('uterus_size', ['normal', 'enlarged', 'small'])->default('normal');
            
            $table->text('cervix_status')->nullable(); // حالة عنق الرحم (Normal / Suspicious)
            $table->text('conclusion')->nullable();    // التشخيص النهائي أو الخلاصة
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_plannings');
    }
};
