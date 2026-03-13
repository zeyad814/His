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
        Schema::create('tooth_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dental_examination_id')->constrained()->onDelete('cascade');
            // النوع: BigInteger (Foreign Key) | الغرض: ربط حالة السن بعملية فحص معينة | الميزة: حذف تلقائي للأسنان عند حذف الفحص.

            $table->integer('tooth_number'); 
            // النوع: Integer | الغرض: تحديد رقم السنة (حسب نظام ISO العالمي) | يستقبل: أرقام الأسنان (مثلاً: الدائمة 11-48، اللبنية 51-85).

            $table->tinyInteger('crown_status')->default(9); 
            // النوع: Integer (Tiny) | الغرض: تخزين حالة "تاج" السنة | يستقبل: أكواد رقمية (0: سليم، 1: مسوس، 2: محشو... إلخ).

            $table->tinyInteger('root_status')->default(9); 
            // النوع: Integer (Tiny) | الغرض: تخزين حالة "جذر" السنة | يستقبل: أكواد رقمية (0: سليم، 1: مسوس، 9: غير مسجل).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tooth_statuses');
    }
};
