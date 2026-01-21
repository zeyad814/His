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
        Schema::create('medical_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('procedure_name', 150); // اسم الإجراء الطبي
            $table->text('benefits')->nullable();  // فوائد الإجراء
            $table->text('refusal_complications')->nullable(); // مضاعفات رفض الإجراء
            $table->text('consent_complications')->nullable(); // مضاعفات الإجراء بعد الموافقة
            $table->text('alternatives')->nullable(); // البدائل العلاجية

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_consents');
    }
};
