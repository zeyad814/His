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
        Schema::create('family_planning_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_planning_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained(); // الطبيب اللي سجل الزيارة

            $table->date('visit_date');

            // سبب الزيارة والإجراء 
            $table->boolean('get_method')->default(false);
            $table->boolean('change_method')->default(false);
            $table->boolean('follow_up_current_method')->default(false);
            $table->boolean('medical_complications')->default(false);
            $table->boolean('remove_iud')->default(false);
            $table->boolean('remove_capsule')->default(false);
            $table->boolean('reproductive_health')->default(false);
            $table->boolean('counseling')->default(false);

            // إجراءات أخرى
            $table->string('referral')->nullable(); // تحويل لمكان تاني
            $table->string('treatment')->nullable(); // علاج موصوف

            // الوسيلة المنصرفة
            $table->string('dispensed_method')->nullable();
            $table->integer('quantity')->default(0);

            $table->date('next_visit_date')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_planning_follow_ups');
    }
};
