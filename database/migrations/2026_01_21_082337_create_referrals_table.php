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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete(); 
            $table->date('referral_date')->nullable(); // تاريخ الإحالة     
            $table->string('transport_method')->nullable(); // وسيلة النقل (إسعاف - سيارة - أخرى)    
            $table->string('target_facility')->nullable(); // الجهة / المنشأة المُحال إليها
            $table->text('reason_for_referral')->nullable(); // سبب الإحالة
            $table->string('specialty')->nullable(); // التخصص المطلوب
            $table->string('type_of_referral')->nullable(); // نوع الإحالة (عاجلة - عادية - متابعة)
            $table->text('relevant_history')->nullable(); // التاريخ المرضي المرتبط بالحالة
            $table->string('referral_serial_no')->nullable(); // الرقم المسلسل للإحالة
            $table->text('exam_findings')->nullable(); // نتائج الفحص
            $table->string('provisional_diag')->nullable();  // التشخيص المبدئي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
