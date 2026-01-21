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
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->date('request_date'); // تاريخ طلب التحليل
            $table->string('test_time', 50)->nullable(); // وقت أو توقيت إجراء التحليل (صباح / مساء)
            $table->string('priority', 20)->default('normal');  // أولوية الطلب (عادي / عاجل)
            $table->text('patient_preparation')->nullable(); // تجهيزات المريض قبل التحليل
            $table->text('diagnoses')->nullable();  // التشخيص أو سبب طلب التحليل
            $table->dateTime('collection_date_time')->nullable(); // تاريخ ووقت سحب العينة
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
