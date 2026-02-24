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
        Schema::create('radiological_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->enum('required_xray', ['أشعة عادية', 'سونار'])->default('أشعة عادية');
            $table->string('body_part', 100)->nullable(); // الجزء المصور من الجسم
            $table->text('diagnoses_reason')->nullable(); // سبب طلب الأشعة / الاشتباه التشخيصي
            $table->enum('priority', ['عادي', 'مستعجل'])->default('عادي'); // أولوية الطلب
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiological_requests');
    }
};
