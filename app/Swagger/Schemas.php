<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Pagination",
 *     title="Pagination",
 *     description="Схема пагинации"
 * )
 * @OA\Property(property="current_page", type="integer", example=1)
 * @OA\Property(property="last_page", type="integer", example=10)
 * @OA\Property(property="per_page", type="integer", example=15)
 * @OA\Property(property="total", type="integer", example=150)
 *
 * @OA\Schema(
 *     schema="Coordinates",
 *     title="Coordinates",
 *     description="Географические координаты"
 * )
 * @OA\Property(property="latitude", type="number", format="float", example=55.7558)
 * @OA\Property(property="longitude", type="number", format="float", example=37.6176)
 */
class Schemas
{
    // Этот класс используется только для документации Swagger
}
