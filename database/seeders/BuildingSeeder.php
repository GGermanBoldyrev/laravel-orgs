<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $knownBuildings = [
            [
                'address' => 'г. Москва, ул. Тверская, д. 12',
                'latitude' => 55.7558,
                'longitude' => 37.6176,
            ],
            [
                'address' => 'г. Москва, ул. Арбат, д. 25',
                'latitude' => 55.7520,
                'longitude' => 37.5932,
            ],
            [
                'address' => 'г. Санкт-Петербург, Невский проспект, д. 50',
                'latitude' => 59.9342,
                'longitude' => 30.3351,
            ],
            [
                'address' => 'г. Екатеринбург, ул. Ленина, д. 8',
                'latitude' => 56.8380,
                'longitude' => 60.5975,
            ],
            [
                'address' => 'г. Новосибирск, ул. Красный проспект, д. 35',
                'latitude' => 55.0302,
                'longitude' => 82.9204,
            ],
        ];

        foreach ($knownBuildings as $building) {
            Building::create($building);
        }

        // Создаем дополнительные здания через фабрику
        Building::factory(45)->create();
    }
}
