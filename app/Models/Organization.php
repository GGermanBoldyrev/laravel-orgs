<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     title="Organization",
 *     description="Модель организации"
 * )
 */
class Organization extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=1)
     * @OA\Property(property="name", type="string", example="ООО Рога и Копыта")
     * @OA\Property(property="building_id", type="integer", example=1)
     * @OA\Property(property="created_at", type="string", format="date-time")
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * @OA\Property(property="building", ref="#/components/schemas/Building")
     * @OA\Property(property="activities", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     * @OA\Property(property="phones", type="array", @OA\Items(ref="#/components/schemas/OrganizationPhone"))
     */
    protected $fillable = [
        'name',
        'building_id',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(OrganizationPhone::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'organization_activities');
    }
}
