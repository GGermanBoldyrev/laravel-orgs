# Organizations API

REST API приложение для справочника Организаций, Зданий и Деятельности.

## Описание

Приложение предоставляет API для работы с:
- **Организациями** - карточки организаций с названием, телефонами, зданием и видами деятельности
- **Зданиями** - информация о зданиях с адресом и географическими координатами
- **Деятельностью** - иерархическая классификация видов деятельности (до 3 уровней)

## Требования

- Docker и Docker Compose
- WSL2 (для Windows)

## Установка и запуск

1. **Клонируйте репозиторий:**
```bash
git clone <repository-url>
cd laravel-orgs
```

2. **Запустите приложение с помощью Laravel Sail:**
```bash
./vendor/bin/sail up -d
```

3. **Выполните миграции и заполните базу данных:**
```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

4. **Добавьте API ключ в .env файл:**
```bash
echo "API_KEY=your-secret-api-key-123" >> .env
```

5. **Сгенерируйте документацию Swagger:**
```bash
./vendor/bin/sail artisan l5-swagger:generate
```

## API Endpoints

### Аутентификация
Все API endpoints требуют API ключ, который передается в заголовке `X-API-Key`.

### Организации

- `GET /api/organizations` - Список всех организаций
- `GET /api/organizations/{id}` - Информация об организации по ID
- `GET /api/organizations/building/{id}` - Организации в конкретном здании
- `GET /api/organizations/activity/{id}` - Организации по виду деятельности
- `GET /api/organizations/search/name?name=...` - Поиск организаций по названию
- `GET /api/organizations/search/activity/{id}` - Поиск организаций по виду деятельности (включая дочерние)
- `GET /api/organizations/nearby?latitude=...&longitude=...&radius=...` - Поиск организаций в радиусе

### Здания

- `GET /api/buildings` - Список всех зданий
- `GET /api/buildings/{id}` - Информация о здании по ID

### Виды деятельности

- `GET /api/activities` - Список всех видов деятельности
- `GET /api/activities/{id}` - Информация о виде деятельности по ID
- `GET /api/activities/tree` - Дерево видов деятельности

## Документация API

После запуска приложения документация Swagger UI доступна по адресу:
```
http://localhost/api/documentation
```

## Примеры использования

### Получение списка организаций
```bash
curl -H "X-API-Key: your-secret-api-key-123" \
     "http://localhost/api/organizations"
```

### Поиск организаций по названию
```bash
curl -H "X-API-Key: your-secret-api-key-123" \
     "http://localhost/api/organizations/search/name?name=Рога"
```

### Поиск организаций в радиусе
```bash
curl -H "X-API-Key: your-secret-api-key-123" \
     "http://localhost/api/organizations/nearby?latitude=55.7558&longitude=37.6176&radius=5"
```

### Получение дерева видов деятельности
```bash
curl -H "X-API-Key: your-secret-api-key-123" \
     "http://localhost/api/activities/tree"
```

## Структура базы данных

### Организации
- `id` - Уникальный идентификатор
- `name` - Название организации
- `building_id` - Ссылка на здание

### Здания
- `id` - Уникальный идентификатор
- `address` - Адрес здания
- `latitude` - Широта
- `longitude` - Долгота

### Виды деятельности
- `id` - Уникальный идентификатор
- `name` - Название вида деятельности
- `parent_id` - Ссылка на родительский вид деятельности
- `level` - Уровень в иерархии (1-3)

### Связи
- `organization_activities` - Связь многие-ко-многим между организациями и видами деятельности
- `organization_phones` - Телефоны организаций

## Тестовые данные

Приложение поставляется с тестовыми данными:
- 64 вида деятельности в иерархической структуре (3 уровня)
- 250 зданий с реальными адресами и координатами
- 200 организаций с случайными названиями, телефонами и видами деятельности

## Развертывание в продакшене

1. Настройте переменные окружения в `.env`:
```env
APP_ENV=production
APP_DEBUG=false
API_KEY=your-secure-production-api-key
```

2. Оптимизируйте приложение:
```bash
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

3. Настройте веб-сервер (nginx/apache) для проксирования запросов к контейнеру Laravel.

## Технологии

- **Backend**: Laravel 12, PHP 8.4
- **Database**: MySQL 8.0
- **Containerization**: Docker, Laravel Sail
- **Documentation**: Swagger/OpenAPI 3.0
- **Authentication**: API Key

## Лицензия

MIT License
