<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\PrakerinPlacement
 *
 * @property int $id
 * @property int $student_id
 * @property int $company_id
 * @property int $supervising_teacher_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $status
 * @property string|null $notes
 * @property int|null $final_grade
 * @property string|null $teacher_feedback
 * @property string|null $company_feedback
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Teacher $supervisingTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyJournal> $dailyJournals
 * @property-read int|null $daily_journals_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereCompanyFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereFinalGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereSupervisingTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereTeacherFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement ongoing()
 * @method static \Illuminate\Database\Eloquent\Builder|PrakerinPlacement completed()
 * @method static \Database\Factories\PrakerinPlacementFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class PrakerinPlacement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'company_id',
        'supervising_teacher_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'final_grade',
        'teacher_feedback',
        'company_feedback',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student for this placement.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the company for this placement.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the supervising teacher for this placement.
     */
    public function supervisingTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'supervising_teacher_id');
    }

    /**
     * Get the daily journals for this placement.
     */
    public function dailyJournals(): HasMany
    {
        return $this->hasMany(DailyJournal::class, 'placement_id');
    }

    /**
     * Scope a query to only include ongoing placements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope a query to only include completed placements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}