<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="OrganizationPhone",
 *     title="OrganizationPhone",
 *     description="Модель телефона организации"
 * )
 */
class OrganizationPhone extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=1)
     * @OA\Property(property="organization_id", type="integer", example=1)
     * @OA\Property(property="phone", type="string", example="+7-123-456-78-90")
     * @OA\Property(property="created_at", type="string", format="date-time")
     * @OA\Property(property="updated_at", type="string", format="date-time")
     */
    protected $fillable = [
        'organization_id',
        'phone',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
