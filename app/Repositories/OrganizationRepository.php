<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getAll(): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])->get();
    }

    public function findById(int $id): ?Organization
    {
        return Organization::find($id);
    }

    public function findByIdWithDetails(int $id): ?Organization
    {
        return Organization::with([
            'building',
            'phones',
            'activities' => function ($query) {
                $query->with('parent');
            }
        ])->find($id);
    }

    public function searchByName(string $query): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])
            ->where('name', 'like', "%{$query}%")
            ->get();
    }

    public function findByBuildingId(int $buildingId): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])
            ->where('building_id', $buildingId)
            ->get();
    }

    public function findByActivityId(int $activityId): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])
            ->whereHas('activities', function ($query) use ($activityId) {
                $query->where('activity_id', $activityId);
            })
            ->get();
    }

    public function findByActivityIds(array $activityIds): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])
            ->whereHas('activities', function ($query) use ($activityIds) {
                $query->whereIn('activity_id', $activityIds);
            })
            ->get();
    }

    public function findByBuildingIds(array $buildingIds): Collection
    {
        return Organization::with(['building', 'phones', 'activities'])
            ->whereIn('building_id', $buildingIds)
            ->get();
    }

    public function create(array $data): Organization
    {
        return Organization::create($data);
    }

    public function update(int $id, array $data): ?Organization
    {
        $organization = Organization::find($id);
        if ($organization) {
            $organization->update($data);
            return $organization->fresh();
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $organization = Organization::find($id);
        return $organization ? $organization->delete() : false;
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Organization::with(['building', 'phones', 'activities']);

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['building_id'])) {
            $query->where('building_id', $filters['building_id']);
        }

        if (!empty($filters['activity_ids'])) {
            $query->whereHas('activities', function ($q) use ($filters) {
                $q->whereIn('activity_id', $filters['activity_ids']);
            });
        }

        if (!empty($filters['building_ids'])) {
            $query->whereIn('building_id', $filters['building_ids']);
        }

        return $query->paginate($perPage);
    }
}
