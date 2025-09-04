<?php

namespace App\Services;

use App\Contracts\Repositories\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    private const EARTH_RADIUS_KM = 6371;

    public function __construct(
        private readonly BuildingRepositoryInterface $buildingRepository
    ) {}

    public function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_KM * $c;
    }

    public function getBuildingsInRadius(float $latitude, float $longitude, float $radiusKm): Collection
    {
        return $this->buildingRepository->findWithinRadius($latitude, $longitude, $radiusKm);
    }

    public function getBuildingsInBounds(array $bounds): Collection
    {
        return $this->buildingRepository->findWithinBounds($bounds);
    }

    public function isWithinRadius(float $lat, float $lng, float $centerLat, float $centerLng, float $radiusKm): bool
    {
        $distance = $this->calculateDistance($lat, $lng, $centerLat, $centerLng);
        return $distance <= $radiusKm;
    }

    public function isWithinBounds(float $lat, float $lng, array $bounds): bool
    {
        return $lat >= $bounds['south'] && $lat <= $bounds['north'] &&
            $lng >= $bounds['west'] && $lng <= $bounds['east'];
    }
}
