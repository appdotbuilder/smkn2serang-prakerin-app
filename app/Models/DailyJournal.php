<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DailyJournal
 *
 * @property int $id
 * @property int $placement_id
 * @property \Illuminate\Support\Carbon $journal_date
 * @property string $activities
 * @property string|null $learning_outcomes
 * @property string|null $challenges
 * @property string $attendance_status
 * @property string|null $clock_in
 * @property string|null $clock_out
 * @property string|null $teacher_comment
 * @property string|null $company_comment
 * @property int|null $teacher_rating
 * @property int|null $company_rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\PrakerinPlacement $placement
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereAttendanceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereChallenges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereClockIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereClockOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereCompanyComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereCompanyRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereJournalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereLearningOutcomes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal wherePlacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereTeacherComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereTeacherRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyJournal whereUpdatedAt($value)
 * @method static \Database\Factories\DailyJournalFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class DailyJournal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'placement_id',
        'journal_date',
        'activities',
        'learning_outcomes',
        'challenges',
        'attendance_status',
        'clock_in',
        'clock_out',
        'teacher_comment',
        'company_comment',
        'teacher_rating',
        'company_rating',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'journal_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the prakerin placement for this journal entry.
     */
    public function placement(): BelongsTo
    {
        return $this->belongsTo(PrakerinPlacement::class, 'placement_id');
    }
}