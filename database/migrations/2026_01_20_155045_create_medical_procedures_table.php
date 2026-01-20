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
        Schema::create('medical_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id') ->nullable()->constrained()->nullOnDelete();
            $table->foreignId('health_unit_id') ->nullable()->constrained()->nullOnDelete();
            $table->boolean('consent_given'); //الموافقه ع الاجرء
            $table->text('diagnosis')->nullable(); //التشخيص
            $table->date('procedure_date');
            $table->time('procedure_time');
            $table->string('procedure_type');
            $table->string('anesthesia_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_procedures');
    }
};
