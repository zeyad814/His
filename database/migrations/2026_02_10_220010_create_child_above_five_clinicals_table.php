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
        Schema::create('child_above_five_clinicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->string('age');
            $table->text('clinical_assessment')->nullable();
            $table->text('nutritional_assessment')->nullable();
            $table->text('psychiatric_screening')->nullable();
            $table->text('school_achievement')->nullable();
            $table->string('hb')->nullable();
            $table->string('urine')->nullable();
            $table->string('stool')->nullable();
            $table->string('other_investigations')->nullable();
            $table->boolean('health_ed_parents')->default(false);
            $table->boolean('health_ed_child')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_above_five_clinicals');
    }
};
