<?php

namespace App\Contracts\Repositories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrganizationRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Organization;
    public function findByIdWithDetails(int $id): ?Organization;
    public function searchByName(string $query): Collection;
    public function findByBuildingId(int $buildingId): Collection;
    public function findByActivityId(int $activityId): Collection;
    public function findByActivityIds(array $activityIds): Collection;
    public function findByBuildingIds(array $buildingIds): Collection;
    public function create(array $data): Organization;
    public function update(int $id, array $data): ?Organization;
    public function delete(int $id): bool;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
