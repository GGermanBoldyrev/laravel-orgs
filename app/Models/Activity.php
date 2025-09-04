<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Activity",
 *     title="Activity",
 *     description="Модель вида деятельности"
 * )
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=1)
     * @OA\Property(property="name", type="string", example="Еда")
     * @OA\Property(property="parent_id", type="integer", nullable=true, example=null)
     * @OA\Property(property="level", type="integer", example=1)
     * @OA\Property(property="created_at", type="string", format="date-time")
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * @OA\Property(property="parent", ref="#/components/schemas/Activity")
     * @OA\Property(property="children", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     * @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/Organization"))
     */
    protected $fillable = [
        'name',
        'parent_id',
        'level',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_activities');
    }

    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }
}
