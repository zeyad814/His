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
        Schema::create('procedure_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_procedure_id')->constrained()->cascadeOnDelete();

            $table->text('diagnosis_details')->nullable();
            $table->text('benefits')->nullable();
            $table->text('complications')->nullable();
            $table->text('alternatives')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_consents');
    }
};
