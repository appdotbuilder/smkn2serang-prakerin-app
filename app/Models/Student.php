<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property int $user_id
 * @property string $nisn
 * @property string $name
 * @property string $class
 * @property string $major
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string $gender
 * @property string|null $parent_name
 * @property string|null $parent_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PrakerinPlacement> $placements
 * @property-read int|null $placements_count
 * @property-read \App\Models\PrakerinPlacement|null $currentPlacement
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNisn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereParentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereParentPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 * @method static \Database\Factories\StudentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nisn',
        'name',
        'class',
        'major',
        'phone',
        'address',
        'birth_date',
        'gender',
        'parent_name',
        'parent_phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prakerin placements for this student.
     */
    public function placements(): HasMany
    {
        return $this->hasMany(PrakerinPlacement::class);
    }

    /**
     * Get the current active prakerin placement.
     */
    public function currentPlacement()
    {
        return $this->hasOne(PrakerinPlacement::class)
                    ->where('status', 'ongoing')
                    ->orWhere(function ($query) {
                        $query->where('status', 'planned')
                              ->where('start_date', '<=', now())
                              ->where('end_date', '>=', now());
                    });
    }
}