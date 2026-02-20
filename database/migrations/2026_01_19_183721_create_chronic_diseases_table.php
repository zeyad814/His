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
        Schema::create('chronic_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->string('diagnosis'); // التشخيص
            $table->text('risk_factors')->nullable(); // عوامل الخطورة
            $table->date('date_diagnosed')->nullable(); // تاريخ التشخيص
            $table->softDeletes();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chronic_diseases');
    }
};
