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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->enum('type', ['core', 'elective', 'optional'])->default('core');
            $table->decimal('credit_hours', 5, 2)->default(0);
            $table->unsignedInteger('theory_hours')->default(0);
            $table->unsignedInteger('practice_hours')->default(0);
            $table->json('assessment_weights')->nullable();
            $table->boolean('prerequisite_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_offered')->default(true);
            $table->unsignedInteger('min_passing_score')->default(50);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->unique(['code', 'grade_id']);
        });

        // subject_prerequisite pivot
        Schema::create('subject_prerequisite', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('prerequisite_subject_id');
            $table->primary(['subject_id','prerequisite_subject_id']);
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('prerequisite_subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        // subject_teacher pivot
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('teacher_id'); // users.id
            $table->string('semester')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->timestamps();

            $table->unique(['subject_id','teacher_id','semester','academic_year_id'],'subject_teacher_unique');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('subject_prerequisite');
        Schema::dropIfExists('subject_teacher');
    }
};
