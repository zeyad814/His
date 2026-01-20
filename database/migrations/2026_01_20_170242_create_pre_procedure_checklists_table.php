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
        Schema::create('pre_procedure_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_procedure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('nurse_id')->nullable()->constrained()->nullOnDelete();

            $table->boolean('labs_done')->default(false);
            $table->boolean('medical_exam')->default(false);
            $table->boolean('site_marked')->default(false);
            $table->boolean('equipment_ready')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_procedure_checklists');
    }
};
