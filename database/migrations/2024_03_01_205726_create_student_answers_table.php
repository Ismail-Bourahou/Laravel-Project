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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_correct')->nullable();
            $table->foreignId('exam_id')->nullable()->constrained('exams')->onDelete('cascade');
            $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained('answer_options')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
