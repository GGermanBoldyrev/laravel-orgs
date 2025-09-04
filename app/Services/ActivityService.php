<?php

namespace App\Services;

use App\Contracts\Repositories\ActivityRepositoryInterface;
use App\Models\Activity;
use Illuminate\Support\Collection;

class ActivityService
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository
    ) {}

    public function getAllDescendantIds(int $activityId): array
    {
        $activity = $this->activityRepository->findById($activityId);

        if (!$activity) {
            return [];
        }

        return $this->getDescendantIdsRecursive($activity);
    }

    private function getDescendantIdsRecursive(Activity $activity): array
    {
        $ids = [$activity->id];

        foreach ($activity->children as $child) {
            $ids = array_merge($ids, $this->getDescendantIdsRecursive($child));
        }

        return $ids;
    }

    public function buildTree(): Collection
    {
        $activities = $this->activityRepository->getAll();

        return $activities->where('parent_id', null)->map(function ($activity) use ($activities) {
            return $this->buildBranch($activity, $activities);
        });
    }

    private function buildBranch(Activity $activity, Collection $activities): array
    {
        $children = $activities->where('parent_id', $activity->id);

        return [
            'id' => $activity->id,
            'name' => $activity->name,
            'level' => $activity->level,
            'children' => $children->map(function ($child) use ($activities) {
                return $this->buildBranch($child, $activities);
            })->values()->toArray()
        ];
    }

    public function validateNestingLevel(int $parentId): bool
    {
        $parent = $this->activityRepository->findById($parentId);
        return !$parent || $parent->level < 3;
    }

    public function getPathToRoot(int $activityId): array
    {
        $activity = $this->activityRepository->findById($activityId);
        if (!$activity) {
            return [];
        }

        $path = [$activity->toArray()];

        while ($activity->parent_id) {
            $activity = $activity->parent;
            array_unshift($path, $activity->toArray());
        }

        return $path;
    }
}
