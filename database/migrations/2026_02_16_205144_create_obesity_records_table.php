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
        Schema::create('obesity_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId("family_member_id")->constrained()->cascadeOnDelete();
            $table->foreignId("doctor_id")->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('visit_date');
            $table->enum('visit_type', ['first_visit', 'follow_up']);
            // مؤشر كتلة الجسم
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);

            $table->boolean('nutrition_counseling')->default(false); 
            $table->boolean('dietary_plan')->default(false);        
            $table->boolean('referral')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obesity_records');
    }
};
