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
        Schema::create('family_injections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete(); 

            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete(); 

            $table->string('procedure_name', 150); // اسم الإجراء / الحقنة
            $table->string('phone', 20)->nullable(); 

            $table->date('visit_date')->nullable(); // تاريخ الزيارة
            $table->time('visit_time')->nullable(); // وقت الزيارة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_injections');
    }
};
