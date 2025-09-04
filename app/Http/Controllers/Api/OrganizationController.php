<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Activity;
use App\Services\OrganizationService;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Organizations API",
 *     version="1.0.0",
 *     description="API для работы с организациями, зданиями и видами деятельности"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     name="X-API-Key",
 *     in="header"
 * )
 */
class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organizationService,
        private readonly ActivityService $activityService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="Получить список всех организаций",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Количество записей на странице",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $organizations = $this->organizationService->getFiltered([], $perPage);

        return response()->json([
            'data' => $organizations->items(),
            'pagination' => [
                'current_page' => $organizations->currentPage(),
                'last_page' => $organizations->lastPage(),
                'per_page' => $organizations->perPage(),
                'total' => $organizations->total(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{organization}",
     *     summary="Получить информацию об организации по ID",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         description="ID организации",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Организация не найдена"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function show(Organization $organization): JsonResponse
    {
        $organizationWithDetails = $this->organizationService->getWithDetails($organization->id);

        if (!$organizationWithDetails) {
            return response()->json(['error' => 'Organization not found'], 404);
        }

        return response()->json([
            'data' => $organizationWithDetails
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/building/{building}",
     *     summary="Получить список организаций в конкретном здании",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         description="ID здания",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="building", ref="#/components/schemas/Building")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Здание не найдено"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function byBuilding(Building $building): JsonResponse
    {
        $organizations = $this->organizationService->getByBuilding($building->id);

        return response()->json([
            'data' => $organizations->items(),
            'building' => $building
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/{activity}",
     *     summary="Получить список организаций по виду деятельности",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         description="ID вида деятельности",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="activity", ref="#/components/schemas/Activity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Вид деятельности не найден"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function byActivity(Activity $activity): JsonResponse
    {
        $organizations = $this->organizationService->getByActivity($activity->id, false);

        return response()->json([
            'data' => $organizations->items(),
            'activity' => $activity
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search/name",
     *     summary="Поиск организаций по названию",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Название организации для поиска",
     *         required=true,
     *         @OA\Schema(type="string", minLength=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="search_term", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function searchByName(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|min:2'
        ]);

        $organizations = $this->organizationService->searchByName($request->name);

        return response()->json([
            'data' => $organizations->items(),
            'search_term' => $request->name
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search/activity/{activity}",
     *     summary="Поиск организаций по виду деятельности (включая дочерние)",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         description="ID вида деятельности",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="activity", ref="#/components/schemas/Activity"),
     *             @OA\Property(property="included_activities", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Вид деятельности не найден"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function searchByActivity(Activity $activity): JsonResponse
    {
        $organizations = $this->organizationService->getByActivity($activity->id, true);
        $activityIds = $this->activityService->getAllDescendantIds($activity->id);
        $activityIds[] = $activity->id;

        return response()->json([
            'data' => $organizations->items(),
            'activity' => $activity,
            'included_activities' => Activity::whereIn('id', $activityIds)->get()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/nearby",
     *     summary="Поиск организаций в радиусе или прямоугольной области",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="Широта центра поиска",
     *         required=true,
     *         @OA\Schema(type="number", format="float", minimum=-90, maximum=90)
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="Долгота центра поиска",
     *         required=true,
     *         @OA\Schema(type="number", format="float", minimum=-180, maximum=180)
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="Радиус поиска в километрах",
     *         required=false,
     *         @OA\Schema(type="number", format="float", minimum=0.1)
     *     ),
     *     @OA\Parameter(
     *         name="rect_width",
     *         in="query",
     *         description="Ширина прямоугольной области в градусах",
     *         required=false,
     *         @OA\Schema(type="number", format="float", minimum=0.1)
     *     ),
     *     @OA\Parameter(
     *         name="rect_height",
     *         in="query",
     *         description="Высота прямоугольной области в градусах",
     *         required=false,
     *         @OA\Schema(type="number", format="float", minimum=0.1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization")),
     *             @OA\Property(property="buildings", type="array", @OA\Items(ref="#/components/schemas/Building")),
     *             @OA\Property(property="search_center", ref="#/components/schemas/Coordinates")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function nearby(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'nullable|numeric|min:0.1',
            'rect_width' => 'nullable|numeric|min:0.1',
            'rect_height' => 'nullable|numeric|min:0.1',
        ]);

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = $request->radius;
        $bounds = null;

        if ($request->has('rect_width') && $request->has('rect_height')) {
            $width = $request->rect_width;
            $height = $request->rect_height;
            $bounds = [
                'north' => $latitude + $height/2,
                'south' => $latitude - $height/2,
                'east' => $longitude + $width/2,
                'west' => $longitude - $width/2,
            ];
        }

        $organizations = $this->organizationService->searchByLocation($latitude, $longitude, $radius, $bounds);

        return response()->json([
            'data' => $organizations->items(),
            'search_center' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        ]);
    }
}
