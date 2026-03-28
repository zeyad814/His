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
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->string('category');      // مثل: Frailty, ADL, Mood
            $table->string('question_text');  // نص السؤال بالعربي أو الإنجليزي
            $table->string('key_name');      // الاسم البرمجي (f_weight_loss) عشان الـ Frontend يعرفه
            $table->string('input_type');    // نوع الإدخال: boolean, integer, text
            $table->json('options')->nullable(); // لو السؤال اختيارات (مثلاً 0, 1, 2 في الـ ADL)
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};
