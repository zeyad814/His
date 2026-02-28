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
            
            $table->dateTime('arrival_at')->nullable(); // تاريخ ووقت الوصول
            $table->text('specialist_findings')->nullable();
            $table->text('hospital_investigations')->nullable();
            $table->text('final_diagnosis')->nullable();
            $table->text('current_medications')->nullable();
            
            // التدخلات (Interventions)
            $table->string('admission_ward')->nullable(); // رقم العنبر إذا وجد
            $table->string('surgery_type')->nullable(); // نوع العملية
            $table->text('other_interventions')->nullable();
            
            $table->text('recommendations')->nullable();
            $table->date('revisit_date')->nullable(); // تاريخ المراجعة
            $table->integer('sick_leave_days')->nullable(); // مدة الإجازة
            $table->text('follow_up_instructions')->nullable();            
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
