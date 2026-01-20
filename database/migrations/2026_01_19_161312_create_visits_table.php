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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id') ->constrained() ->cascadeOnDelete();
            $table->date('date'); // تاريخ الزيارة
            $table->string('visit_type')->nullable();
            $table->text('complaint')->nullable(); // الشكوى الرئيسية
            $table->text('clinical_examination')->nullable();  // الفحص الإكلينيكي
            $table->text('investigations')->nullable(); // الفحوصات والتحاليل
            $table->text('diagnoses')->nullable(); // التشخيص
            $table->text('management_follow_up')->nullable(); //  الخطة العلاجيه والمتابعه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
