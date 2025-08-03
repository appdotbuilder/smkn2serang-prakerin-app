<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CompanyRepresentative
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $name
 * @property string $position
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Company $company
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyRepresentative whereUserId($value)
 * @method static \Database\Factories\CompanyRepresentativeFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CompanyRepresentative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'position',
        'phone',
        'email',
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
     * Get the user that owns the company representative profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that this representative belongs to.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}