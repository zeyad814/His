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
            $table->date('last_menstrual_period')->nullable();
            $table->date('expected_delivery_date')->nullable(); // موعد الولادة المتوقع
            $table->string('pregnancy_status')->nullable(); // حالة الحمل
            $table->boolean('previous_cesarean')->nullable(); // ولادة قيصرية سابقة
            $table->integer('gravidity')->nullable();  // عدد مرات الحمل
            $table->integer('parity')->nullable();  // عدد الولادات
            $table->integer('abortions')->nullable(); // عدد الإجهاضات
            $table->integer('living_children')->nullable(); // عدد الأطفال الأحياء
            $table->integer('previous_stillbirths')->nullable();  // ولادات ميتة
            $table->string('blood_type')->nullable();
            $table->string('rh_factor')->nullable();
            $table->string('syphilis_test_result')->nullable(); // نتيجة الزهري
            $table->date('last_tetanus_date')->nullable(); // آخر تطعيم تيتانوس
            $table->integer('tetanus_doses')->nullable(); // عدد الجرعات
            $table->string('tetanus_immunity_status')->nullable();  // حالة المناعة
            $table->boolean('consanguinity')->nullable();  // زواج أقارب
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
