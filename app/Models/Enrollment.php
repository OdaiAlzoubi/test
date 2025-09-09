<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Enum\EnrollmentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'grade_id',
        'section_id',
        'admission_date',
        'status',
        'graduation_date',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnrollmentStatusEnum::class,
            'admission_date' => 'datetime',
            'graduation_date' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
