<?php

namespace App\Services;

use App\Contracts\Repositories\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationService
{
    public function __construct(
        private readonly OrganizationRepositoryInterface $organizationRepository,
        private readonly LocationService                 $locationService,
        private readonly ActivityService                 $activityService
    ) {}

    public function searchByName(string $query, int $perPage = 15): LengthAwarePaginator
    {
        $filters = ['name' => $query];
        return $this->organizationRepository->paginate($filters, $perPage);
    }

    public function getByBuilding(int $buildingId, int $perPage = 15): LengthAwarePaginator
    {
        $filters = ['building_id' => $buildingId];
        return $this->organizationRepository->paginate($filters, $perPage);
    }

    public function getByActivity(int $activityId, bool $includeChildren = true, int $perPage = 15): LengthAwarePaginator
    {
        $activityIds = $includeChildren
            ? $this->activityService->getAllDescendantIds($activityId)
            : [$activityId];

        $filters = ['activity_ids' => $activityIds];
        return $this->organizationRepository->paginate($filters, $perPage);
    }

    public function searchByLocation(
        float $latitude,
        float $longitude,
        float $radiusKm = null,
        array $bounds = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $buildingIds = [];

        if ($radiusKm !== null) {
            $buildings = $this->locationService->getBuildingsInRadius($latitude, $longitude, $radiusKm);
            $buildingIds = $buildings->pluck('id')->toArray();
        } elseif ($bounds !== null) {
            $buildings = $this->locationService->getBuildingsInBounds($bounds);
            $buildingIds = $buildings->pluck('id')->toArray();
        }

        $filters = ['building_ids' => $buildingIds];
        return $this->organizationRepository->paginate($filters, $perPage);
    }

    public function getWithDetails(int $id): ?Organization
    {
        return $this->organizationRepository->findByIdWithDetails($id);
    }

    public function getFiltered(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->organizationRepository->paginate($filters, $perPage);
    }
}
