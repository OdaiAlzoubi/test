<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;

    protected $table = 'student_guardian';

    protected $fillable = [
        'student_id',
        'guardian_user_id',
        'relation',
        'is_primary',
    ];
}
