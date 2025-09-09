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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->date('admission_date')->nullable();
            $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active');
            $table->date('graduation_date')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['student_id', 'academic_year_id'], 'enrollment_unique_per_year');

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
