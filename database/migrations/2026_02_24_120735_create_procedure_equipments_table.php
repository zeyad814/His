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
        Schema::create('procedure_equipments', function (Blueprint $table) {
            $table->id();
            // الربط مع جدول العمليات الأساسي
            $table->foreignId('surgery_uterus_id')->constrained('surgery_uteruses')->cascadeOnDelete();

            $table->string('name'); // اسم الأداة
            $table->string('status')->nullable(); // حالة الأداة  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_equipments');
    }
};
