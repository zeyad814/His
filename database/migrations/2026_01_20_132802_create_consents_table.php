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
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->text('disclosure_agreement')->nullable(); // إقرار الإفصاح
            $table->boolean('groom_finger_print_status')->nullable(); // حالة بصمة العريس
            $table->date('consent_date')->nullable(); // تاريخ الموافقة
            $table->string('unit_manager')->nullable(); // مدير الوحدة

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
