<?php

namespace App\Contracts\Repositories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ActivityRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Activity;
    public function findByIdWithDetails(int $id): ?Activity;
    public function getRoots(): Collection;
    public function getLeaves(): Collection;
    public function findByParentId(?int $parentId): Collection;
    public function getWithChildren(int $id): ?Activity;
    public function create(array $data): Activity;
    public function update(int $id, array $data): ?Activity;
    public function delete(int $id): bool;
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
