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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete(); 
            $table->string('referral_number')->unique(); // رقم الإحالة في السجل
            $table->string('referred_to_entity')->nullable(); // الجهة المحول إليها
            $table->string('specialty')->nullable(); // التخصص
            $table->string('transport_method')->nullable(); // وسيلة الانتقال (إسعاف/بمعرفته)
            
            $table->text('reason_for_referral')->nullable();
            $table->enum('urgency_type', ['emergency', 'urgent', 'non_urgent'])->default('non_urgent');
            
            // العلامات الحيوية
            $table->string('bp')->nullable(); // Blood Pressure
            $table->integer('pulse')->nullable();
            $table->decimal('temp', 4, 1)->nullable();
            $table->integer('rr')->nullable(); // Respiratory Rate
            
            $table->text('relevant_history')->nullable();
            $table->text('exam_findings')->nullable();
            $table->text('relevant_investigations')->nullable();
            $table->text('provisional_diagnosis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
