<?php

namespace App\Contracts\Repositories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Building;
    public function findByIdWithDetails(int $id): ?Building;
    public function findWithinRadius(float $latitude, float $longitude, float $radiusKm): Collection;
    public function findWithinBounds(array $bounds): Collection;
    public function create(array $data): Building;
    public function update(int $id, array $data): ?Building;
    public function delete(int $id): bool;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
