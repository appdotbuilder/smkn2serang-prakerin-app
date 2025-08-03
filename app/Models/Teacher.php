<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property int $user_id
 * @property string $nip
 * @property string $name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $subject
 * @property string $role
 * @property string|null $homeroom_class
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PrakerinPlacement> $supervisedPlacements
 * @property-read int|null $supervised_placements_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereHomeroomClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher supervisingTeachers()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher homeroomTeachers()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher vicePrincipals()
 * @method static \Database\Factories\TeacherFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'phone',
        'address',
        'subject',
        'role',
        'homeroom_class',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the teacher profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prakerin placements supervised by this teacher.
     */
    public function supervisedPlacements(): HasMany
    {
        return $this->hasMany(PrakerinPlacement::class, 'supervising_teacher_id');
    }

    /**
     * Scope a query to only include supervising teachers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSupervisingTeachers($query)
    {
        return $query->where('role', 'supervising_teacher');
    }

    /**
     * Scope a query to only include homeroom teachers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHomeroomTeachers($query)
    {
        return $query->where('role', 'homeroom_teacher');
    }

    /**
     * Scope a query to only include vice principals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVicePrincipals($query)
    {
        return $query->where('role', 'vice_principal');
    }
}