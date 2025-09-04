<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'parent_id' => null,
            'level' => 1,
        ];
    }

    public function withParent(int $parentId, int $level): static
    {
        return $this->state([
            'parent_id' => $parentId,
            'level' => $level,
        ]);
    }

    public function level1(): static
    {
        return $this->state([
            'parent_id' => null,
            'level' => 1,
        ]);
    }

    public function level2(int $parentId): static
    {
        return $this->state([
            'parent_id' => $parentId,
            'level' => 2,
        ]);
    }

    public function level3(int $parentId): static
    {
        return $this->state([
            'parent_id' => $parentId,
            'level' => 3,
        ]);
    }
}
