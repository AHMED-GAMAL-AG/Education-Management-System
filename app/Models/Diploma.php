<?php

namespace App\Models;

use App\Enums\DiplomaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diploma extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'duration',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => DiplomaStatus::class,
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function diplomaSubjects(): HasMany
    {
        return $this->hasMany(DiplomaSubject::class);
    }
}
