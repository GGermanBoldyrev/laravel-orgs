<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Services\LocationService;
use App\Contracts\Repositories\BuildingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="API endpoints для работы со зданиями"
 * )
 */
class BuildingController extends Controller
{
    public function __construct(
        private readonly BuildingRepositoryInterface $buildingRepository,
        private readonly LocationService $locationService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Получить список всех зданий",
     *     tags={"Buildings"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Building")),
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
        $buildings = $this->buildingRepository->paginate([], $perPage);

        return response()->json([
            'data' => $buildings->items(),
            'pagination' => [
                'current_page' => $buildings->currentPage(),
                'last_page' => $buildings->lastPage(),
                'per_page' => $buildings->perPage(),
                'total' => $buildings->total(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/buildings/{building}",
     *     summary="Получить информацию о здании по ID",
     *     tags={"Buildings"},
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
     *             @OA\Property(property="data", ref="#/components/schemas/Building")
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
    public function show(Building $building): JsonResponse
    {
        $buildingWithDetails = $this->buildingRepository->findByIdWithDetails($building->id);

        if (!$buildingWithDetails) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        return response()->json([
            'data' => $buildingWithDetails
        ]);
    }
}
