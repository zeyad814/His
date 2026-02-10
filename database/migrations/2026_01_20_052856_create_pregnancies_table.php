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
        Schema::create('pregnancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            //تواريخ اساسية
            $table->date('last_menstrual_period')->nullable();
            $table->date('expected_delivery_date')->nullable(); // موعد الولادة المتوقع
            $table->string('pregnancy_status')->nullable(); // حالة الحمل

            // obstetric History التاريخ السابق
            $table->integer('gravidity')->default(0);  // عدد مرات الحمل
            $table->integer('parity')->default(0);  // عدد الولادات
            $table->integer('abortions')->default(0); // عدد الإجهاضات
            $table->integer('living_children')->default(0);// عدد الأطفال الأحياء
            $table->integer('previous_stillbirths')->default(0); // ولادات ميتة
            $table->integer('previous_cesarean')->default(0);// ولادة قيصرية سابقة
            
            //بيانات الدم والمناعة
            $table->string('blood_type')->nullable();
            $table->string('rh_factor')->nullable();
            $table->string('syphilis_test_result')->nullable(); // نتيجة الزهري

            //tetanus
            $table->date('last_tetanus_date')->nullable(); // آخر تطعيم تيتانوس
            $table->integer('tetanus_doses')->default(0); // عدد الجرعات
            $table->string('tetanus_immunity_status')->nullable();  // حالة المناعة
            
            //other
            $table->boolean('consanguinity')->default(false);  // زواج أقارب

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancies');
    }
};
