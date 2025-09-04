<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::all();
        $activities = Activity::all();

        // Создаем организации
        Organization::factory(200)->create()->each(function ($organization) use ($activities) {
            // Привязываем случайные виды деятельности (1-4 вида)
            $randomActivities = $activities->random(rand(1, 4));
            $organization->activities()->attach($randomActivities->pluck('id'));

            // Добавляем телефоны (1-3 номера)
            $phoneCount = rand(1, 3);
            for ($i = 0; $i < $phoneCount; $i++) {
                $organization->phones()->create([
                    'phone' => $this->generatePhoneNumber(),
                ]);
            }
        });
    }

    private function generatePhoneNumber(): string
    {
        $formats = [
            '+7-###-###-##-##',
            '8-###-###-##-##',
            '+7(###)###-##-##',
            '8(###)###-##-##',
            '###-##-##',
        ];

        $format = collect($formats)->random();

        return preg_replace_callback('/#+/', function ($matches) {
            $length = strlen($matches[0]);
            $number = '';
            for ($i = 0; $i < $length; $i++) {
                $number .= rand(0, 9);
            }
            return $number;
        }, $format);
    }
}
