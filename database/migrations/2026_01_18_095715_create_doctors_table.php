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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->foreignId('health_unit_id')->nullable()->constrained()->nullOnDelete();
            $table->char('national_id',14)->unique();
            $table->string('name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('specialization', 50); //family or dentist
            $table->string('license_number', 50)->nullable();
            $table->date('start_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
