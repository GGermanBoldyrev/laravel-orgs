<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Building",
 *     title="Building",
 *     description="Модель здания"
 * )
 */
class Building extends Model
{
    use HasFactory;

    /**
     * @OA\Property(property="id", type="integer", example=1)
     * @OA\Property(property="address", type="string", example="г. Москва, ул. Ленина 1, офис 3")
     * @OA\Property(property="latitude", type="number", format="float", example=55.7558)
     * @OA\Property(property="longitude", type="number", format="float", example=37.6176)
     * @OA\Property(property="created_at", type="string", format="date-time")
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * @OA\Property(property="organizations", type="array", @OA\Items(ref="#/components/schemas/Organization"))
     */
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
