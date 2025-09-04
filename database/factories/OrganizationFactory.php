<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $organizationTypes = ['ООО', 'ИП', 'АО', 'ЗАО', 'НКО'];
        $businessNames = [
            'Рога и Копыта', 'Золотой Ключик', 'Успешный Бизнес',
            'Надежный Партнер', 'Инновации Плюс', 'Качество Сервис',
            'Мегасвязь', 'СтройМастер', 'ТехноСила', 'БизнесГрупп',
            'Альфа Продукт', 'Омега Трейд', 'Универсал Групп',
            'Прогресс Инвест', 'Элит Сервис'
        ];

        return [
            'name' => sprintf(
                '%s "%s"',
                $this->faker->randomElement($organizationTypes),
                $this->faker->randomElement($businessNames)
            ),
            'building_id' => Building::factory(),
        ];
    }

    public function inBuilding(int $buildingId): static
    {
        return $this->state([
            'building_id' => $buildingId,
        ]);
    }
}
