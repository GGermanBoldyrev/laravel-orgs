<?php

namespace App\Repositories;

use App\Contracts\Repositories\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Building;

class BuildingRepository implements BuildingRepositoryInterface
{
    private const EARTH_RADIUS_KM = 6371;

    public function getAll(): Collection
    {
        return Building::all();
    }

    public function findById(int $id): ?Building
    {
        return Building::find($id);
    }

    public function findByIdWithDetails(int $id): ?Building
    {
        return Building::with('organizations')->find($id);
    }

    public function findWithinRadius(float $latitude, float $longitude, float $radiusKm): Collection
    {
        return Building::selectRaw("
            *,
            (? * acos(
                cos(radians(?)) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) *
                sin(radians(latitude))
            )) AS distance
        ", [self::EARTH_RADIUS_KM, $latitude, $longitude, $latitude])
            ->having('distance', '<=', $radiusKm)
            ->orderBy('distance')
            ->get();
    }

    public function findWithinBounds(array $bounds): Collection
    {
        return Building::whereBetween('latitude', [$bounds['south'], $bounds['north']])
            ->whereBetween('longitude', [$bounds['west'], $bounds['east']])
            ->get();
    }

    public function create(array $data): Building
    {
        return Building::create($data);
    }

    public function update(int $id, array $data): ?Building
    {
        $building = Building::find($id);
        if ($building) {
            $building->update($data);
            return $building->fresh();
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $building = Building::find($id);
        return $building ? $building->delete() : false;
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Building::with('organizations');

        // Здесь можно добавить фильтры если понадобится
        // if (!empty($filters['some_filter'])) {
        //     $query->where('some_field', $filters['some_filter']);
        // }

        return $query->paginate($perPage);
    }
}
