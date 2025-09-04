<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очищаем таблицу перед заполнением
        Activity::query()->delete();

        $this->command->info('Creating activities hierarchy...');

        // Уровень 1 - Основные категории
        $food = Activity::create([
            'name' => 'Еда',
            'parent_id' => null,
            'level' => 1,
        ]);

        $auto = Activity::create([
            'name' => 'Автомобили',
            'parent_id' => null,
            'level' => 1,
        ]);

        $construction = Activity::create([
            'name' => 'Строительство',
            'parent_id' => null,
            'level' => 1,
        ]);

        $it = Activity::create([
            'name' => 'IT и технологии',
            'parent_id' => null,
            'level' => 1,
        ]);

        $education = Activity::create([
            'name' => 'Образование',
            'parent_id' => null,
            'level' => 1,
        ]);

        // Уровень 2 для Еда
        $meat = Activity::create([
            'name' => 'Мясная продукция',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        $milk = Activity::create([
            'name' => 'Молочная продукция',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        $bakery = Activity::create([
            'name' => 'Хлебобулочные изделия',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        $confectionery = Activity::create([
            'name' => 'Кондитерские изделия',
            'parent_id' => $food->id,
            'level' => 2,
        ]);

        // Уровень 2 для Автомобили
        $trucks = Activity::create([
            'name' => 'Грузовые',
            'parent_id' => $auto->id,
            'level' => 2,
        ]);

        $cars = Activity::create([
            'name' => 'Легковые',
            'parent_id' => $auto->id,
            'level' => 2,
        ]);

        $motorcycles = Activity::create([
            'name' => 'Мотоциклы',
            'parent_id' => $auto->id,
            'level' => 2,
        ]);

        // Уровень 3 для Грузовые
        Activity::create([
            'name' => 'Запчасти для грузовых',
            'parent_id' => $trucks->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Ремонт грузовых',
            'parent_id' => $trucks->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Продажа грузовых',
            'parent_id' => $trucks->id,
            'level' => 3,
        ]);

        // Уровень 3 для Легковые
        Activity::create([
            'name' => 'Запчасти',
            'parent_id' => $cars->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Аксессуары',
            'parent_id' => $cars->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Ремонт легковых',
            'parent_id' => $cars->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Продажа легковых',
            'parent_id' => $cars->id,
            'level' => 3,
        ]);

        // Уровень 3 для Мотоциклы
        Activity::create([
            'name' => 'Запчасти для мотоциклов',
            'parent_id' => $motorcycles->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Аксессуары для мотоциклов',
            'parent_id' => $motorcycles->id,
            'level' => 3,
        ]);

        // Уровень 2 для Строительство
        $residential = Activity::create([
            'name' => 'Жилое строительство',
            'parent_id' => $construction->id,
            'level' => 2,
        ]);

        $commercial = Activity::create([
            'name' => 'Коммерческое строительство',
            'parent_id' => $construction->id,
            'level' => 2,
        ]);

        $renovation = Activity::create([
            'name' => 'Ремонт и отделка',
            'parent_id' => $construction->id,
            'level' => 2,
        ]);

        // Уровень 3 для Жилое строительство
        Activity::create([
            'name' => 'Квартиры',
            'parent_id' => $residential->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Частные дома',
            'parent_id' => $residential->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Многоквартирные дома',
            'parent_id' => $residential->id,
            'level' => 3,
        ]);

        // Уровень 3 для Коммерческое строительство
        Activity::create([
            'name' => 'Офисные здания',
            'parent_id' => $commercial->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Торговые центры',
            'parent_id' => $commercial->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Складские помещения',
            'parent_id' => $commercial->id,
            'level' => 3,
        ]);

        // Уровень 3 для Ремонт и отделка
        Activity::create([
            'name' => 'Внутренняя отделка',
            'parent_id' => $renovation->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Внешняя отделка',
            'parent_id' => $renovation->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Сантехнические работы',
            'parent_id' => $renovation->id,
            'level' => 3,
        ]);

        // Уровень 2 для IT
        $development = Activity::create([
            'name' => 'Разработка ПО',
            'parent_id' => $it->id,
            'level' => 2,
        ]);

        $consulting = Activity::create([
            'name' => 'Консультирование',
            'parent_id' => $it->id,
            'level' => 2,
        ]);

        $internet = Activity::create([
            'name' => 'Интернет-провайдеры',
            'parent_id' => $it->id,
            'level' => 2,
        ]);

        $hardware = Activity::create([
            'name' => 'Компьютерная техника',
            'parent_id' => $it->id,
            'level' => 2,
        ]);

        // Уровень 3 для Разработка ПО
        Activity::create([
            'name' => 'Веб-разработка',
            'parent_id' => $development->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Мобильные приложения',
            'parent_id' => $development->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Десктопные приложения',
            'parent_id' => $development->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Системная интеграция',
            'parent_id' => $development->id,
            'level' => 3,
        ]);

        // Уровень 3 для Консультирование
        Activity::create([
            'name' => 'IT-консалтинг',
            'parent_id' => $consulting->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Аудит IT-систем',
            'parent_id' => $consulting->id,
            'level' => 3,
        ]);

        // Уровень 3 для Интернет-провайдеры
        Activity::create([
            'name' => 'Домашний интернет',
            'parent_id' => $internet->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Корпоративный интернет',
            'parent_id' => $internet->id,
            'level' => 3,
        ]);

        // Уровень 3 для Компьютерная техника
        Activity::create([
            'name' => 'Продажа компьютеров',
            'parent_id' => $hardware->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Ремонт компьютеров',
            'parent_id' => $hardware->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Компьютерные аксессуары',
            'parent_id' => $hardware->id,
            'level' => 3,
        ]);

        // Уровень 2 для Образование
        $school = Activity::create([
            'name' => 'Школьное образование',
            'parent_id' => $education->id,
            'level' => 2,
        ]);

        $university = Activity::create([
            'name' => 'Высшее образование',
            'parent_id' => $education->id,
            'level' => 2,
        ]);

        $courses = Activity::create([
            'name' => 'Курсы и тренинги',
            'parent_id' => $education->id,
            'level' => 2,
        ]);

        $preschool = Activity::create([
            'name' => 'Дошкольное образование',
            'parent_id' => $education->id,
            'level' => 2,
        ]);

        // Уровень 3 для Школьное образование
        Activity::create([
            'name' => 'Начальная школа',
            'parent_id' => $school->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Средняя школа',
            'parent_id' => $school->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Старшая школа',
            'parent_id' => $school->id,
            'level' => 3,
        ]);

        // Уровень 3 для Высшее образование
        Activity::create([
            'name' => 'Бакалавриат',
            'parent_id' => $university->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Магистратура',
            'parent_id' => $university->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Аспирантура',
            'parent_id' => $university->id,
            'level' => 3,
        ]);

        // Уровень 3 для Курсы и тренинги
        Activity::create([
            'name' => 'IT курсы',
            'parent_id' => $courses->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Языковые курсы',
            'parent_id' => $courses->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Бизнес-тренинги',
            'parent_id' => $courses->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Курсы повышения квалификации',
            'parent_id' => $courses->id,
            'level' => 3,
        ]);

        // Уровень 3 для Дошкольное образование
        Activity::create([
            'name' => 'Детские сады',
            'parent_id' => $preschool->id,
            'level' => 3,
        ]);

        Activity::create([
            'name' => 'Центры раннего развития',
            'parent_id' => $preschool->id,
            'level' => 3,
        ]);

        $this->command->info('Activities hierarchy created successfully!');
        $this->command->info('Total activities created: ' . Activity::count());
    }
}
