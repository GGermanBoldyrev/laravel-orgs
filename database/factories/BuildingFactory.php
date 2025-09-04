<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            ['lat' => 55.751244, 'lng' => 37.618423, 'city' => 'Москва'],
            ['lat' => 59.934280, 'lng' => 30.335099, 'city' => 'Санкт-Петербург'],
            ['lat' => 56.838011, 'lng' => 60.597465, 'city' => 'Екатеринбург'],
            ['lat' => 55.030204, 'lng' => 82.920430, 'city' => 'Новосибирск'],
            ['lat' => 56.326797, 'lng' => 44.005986, 'city' => 'Нижний Новгород'],
        ];

        $city = $this->faker->randomElement($cities);

        $latOffset = $this->faker->randomFloat(6, -0.1, 0.1);
        $lngOffset = $this->faker->randomFloat(6, -0.1, 0.1);

        return [
            'address' => sprintf(
                'г. %s, %s, д. %d%s',
                $city['city'],
                $this->faker->streetName(),
                $this->faker->numberBetween(1, 200),
                $this->faker->optional(0.3)->randomElement(['/1', '/2', 'А', 'Б', 'к1'])
            ),
            'latitude' => $city['lat'] + $latOffset,
            'longitude' => $city['lng'] + $lngOffset,
        ];
    }
}
