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
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            // مربوط بالرأس (التي تحتوي على التوكن والدكتور والمريض)
            $table->foreignId('geriatric_assessment_id')->constrained()->onDelete('cascade');

            // مربوط بالسؤال نفسه
            $table->foreignId('assessment_question_id')->constrained('assessment_questions');

            // قيمة الإجابة (بنخليها text عشان تشيل true/false أو أرقام أو نصوص)
            $table->text('answer_value')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
