<?php

namespace App\Repositories;

use App\Contracts\Repositories\ActivityRepositoryInterface;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function getAll(): Collection
    {
        return Activity::orderBy('level')->orderBy('name')->get();
    }

    public function findById(int $id): ?Activity
    {
        return Activity::find($id);
    }

    public function findByIdWithDetails(int $id): ?Activity
    {
        return Activity::with(['parent', 'children', 'organizations'])->find($id);
    }

    public function getRoots(): Collection
    {
        return Activity::whereNull('parent_id')->orderBy('name')->get();
    }

    public function getLeaves(): Collection
    {
        return Activity::whereDoesntHave('children')->orderBy('name')->get();
    }

    public function findByParentId(?int $parentId): Collection
    {
        return Activity::where('parent_id', $parentId)->orderBy('name')->get();
    }

    public function getWithChildren(int $id): ?Activity
    {
        return Activity::with(['children', 'parent'])->find($id);
    }

    public function create(array $data): Activity
    {
        // Автоматически вычисляем уровень
        if (!empty($data['parent_id'])) {
            $parent = Activity::find($data['parent_id']);
            if ($parent) {
                if ($parent->level >= 3) {
                    throw new \Exception('Maximum nesting level (3) exceeded');
                }
                $data['level'] = $parent->level + 1;
            }
        } else {
            $data['level'] = 1;
        }

        return Activity::create($data);
    }

    public function update(int $id, array $data): ?Activity
    {
        $activity = Activity::find($id);
        if ($activity) {
            // Если меняем родителя, пересчитываем уровень
            if (isset($data['parent_id']) && $data['parent_id'] !== $activity->parent_id) {
                if ($data['parent_id']) {
                    $parent = Activity::find($data['parent_id']);
                    if ($parent && $parent->level >= 3) {
                        throw new \Exception('Maximum nesting level (3) exceeded');
                    }
                    $data['level'] = $parent ? $parent->level + 1 : 1;
                } else {
                    $data['level'] = 1;
                }
            }

            $activity->update($data);
            return $activity->fresh();
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $activity = Activity::find($id);
        return $activity ? $activity->delete() : false;
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Activity::orderBy('level')->orderBy('name');

        // Здесь можно добавить фильтры если понадобится
        // if (!empty($filters['some_filter'])) {
        //     $query->where('some_field', $filters['some_filter']);
        // }

        return $query->paginate($perPage);
    }
}
