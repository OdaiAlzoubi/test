<?php

namespace App\Models;

use App\Models\Grade;
use App\Enum\SubjectTypeEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'description',
        'grade_id',
        'type',
        'credit_hours',
        'theory_hours',
        'practice_hours',
        'assessment_weights',
        'prerequisite_required',
        'is_active',
        'is_offered',
        'min_passing_score',
    ];

    protected function casts(): array
    {
        return [
            'assessment_weights' => 'json',
            'type' => SubjectTypeEnum::class,
            'is_active' => 'boolean',
            'is_offered' => 'boolean',
            'prerequisite_required' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
