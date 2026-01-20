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
        Schema::create('procedure_time_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_procedure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('nurse_id') ->nullable()->constrained()->nullOnDelete();
            $table->boolean('patient_confirmed');
            $table->boolean('procedure_confirmed');
            $table->boolean('site_confirmed');
            $table->boolean('antibiotic_given');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_time_outs');
    }
};
