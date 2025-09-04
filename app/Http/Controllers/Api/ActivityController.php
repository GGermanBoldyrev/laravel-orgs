<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Services\ActivityService;
use App\Contracts\Repositories\ActivityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Activities",
 *     description="API endpoints для работы с видами деятельности"
 * )
 */
class ActivityController extends Controller
{
    public function __construct(
        private readonly ActivityService $activityService,
        private readonly ActivityRepositoryInterface $activityRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/activities",
     *     summary="Получить список всех видов деятельности",
     *     tags={"Activities"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Activity")),
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
        $activities = $this->activityRepository->paginate([], $perPage);

        return response()->json([
            'data' => $activities->items(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/activities/{activity}",
     *     summary="Получить информацию о виде деятельности по ID",
     *     tags={"Activities"},
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
     *             @OA\Property(property="data", ref="#/components/schemas/Activity")
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
    public function show(Activity $activity): JsonResponse
    {
        $activityWithDetails = $this->activityRepository->findByIdWithDetails($activity->id);

        if (!$activityWithDetails) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        return response()->json([
            'data' => $activityWithDetails
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/activities/tree",
     *     summary="Получить дерево видов деятельности",
     *     tags={"Activities"},
     *     security={{"api_key":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Activity"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function tree(): JsonResponse
    {
        $tree = $this->activityService->buildTree();

        return response()->json([
            'data' => $tree
        ]);
    }
}
