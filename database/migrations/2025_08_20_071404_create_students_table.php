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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id')->unique(); // link to users
            $table->string('student_number')->nullable()->unique();
            $table->date('admission_date')->nullable();
            $table->enum('enrollment_status', ['active', 'graduated', 'withdrawn', 'suspended'])->default('active');
            $table->string('roll_number')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('nationality')->nullable();
            $table->json('emergency_contact')->nullable();
            $table->unsignedBigInteger('current_grade_id')->nullable();
            $table->unsignedBigInteger('current_section_id')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('current_grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->foreign('current_section_id')->references('id')->on('sections')->onDelete('set null');
        });

        // student_guardian pivot (guardian is a user)
        Schema::create('student_guardian', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('guardian_user_id');
            $table->string('relation')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->primary(['student_id', 'guardian_user_id']);

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('guardian_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('student_guardian');
    }
};
