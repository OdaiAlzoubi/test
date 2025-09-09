<?php

namespace App\Models;

use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRolesAndPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'national_number',
        'password',
        'is_active',
        'gender',
        'date_of_birth',
        'address',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(UserObserver::class);
        // static::creating(function ($model) {
        //     $model->uuid = (string) Str::uuid();
        // });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
        'phone_verified_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'address' => 'json',
            'is_active' => 'boolean',
            'role' => RoleEnum::class,
            'gender' => GenderEnum::class,
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function guardianStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_guardian', 'guardian_user_id', 'student_id')->withPivot('relation', 'is_primary');
    }
}
