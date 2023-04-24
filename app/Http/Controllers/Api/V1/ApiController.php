<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\SwapiService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PeopleRequest;
use App\Http\Requests\PlanetRequest;
use App\Http\Requests\VehicleRequest;

/**
 * @OA\Info(title="API", version="1.0")
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth"
 * )
 */
class ApiController extends Controller
{
    /**
     * @var SwapiService
     */
    protected $swapiService;

    /**
     * ApiController constructor.
     *
     * @param SwapiService $swapiService
     */
    public function __construct(SwapiService $swapiService)
    {
        $this->swapiService = $swapiService;
    }

    /**
     * Get all people from SWAPI.
     *
     * @OA\Get(
     *     path="/api/v1/people",
     *     summary="Get all people",
     *     tags={"People"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results per page",
     *         @OA\Schema(
     *             type="integer",
     *             default="10"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Number of results to skip",
     *         @OA\Schema(
     *             type="integer",
     *             default="0"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of people",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * 
     * @param PeopleRequest $request
     * @return Response
     * @throws ValidationException
     */
    public function getPeople(PeopleRequest $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $people = $this->swapiService->getPeople($limit, $offset);

            return response()->json($people, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting the people.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

    /**
     * Get a specific people from SWAPI by ID.
     *
     * @OA\Get(
     *     path="/api/v1/people/{id}",
     *     summary="Get a specific people by ID",
     *     tags={"People"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the people to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="People details",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="People not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function getPeopleById($id)
    {
        try {
            $validator = Validator::make(
                ['id' => $id],
                ['id' => 'required|integer|min:1']
            );

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $person = $this->swapiService->getPeopleById($id);

            return response()->json($person, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting the people.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all planets from SWAPI.
     *
     * @OA\Get(
     *     path="/api/v1/planets",
     *     summary="Get all planets",
     *     tags={"Planets"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results per page",
     *         @OA\Schema(
     *             type="integer",
     *             default="10"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Number of results to skip",
     *         @OA\Schema(
     *             type="integer",
     *             default="0"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of planets",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function getPlanets(PlanetRequest $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $planets = $this->swapiService->getPlanets($limit, $offset);

            return response()->json($planets, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting planets.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a specific planet by ID from SWAPI.
     *
     * @OA\Get(
     *     path="/api/v1/planets/{id}",
     *     summary="Get a specific planet by ID",
     *     tags={"Planets"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the planet",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example="1",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the planet",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function getPlanetById($id)
    {
        try {
            $planet = $this->swapiService->getPlanetById($id);

            return response()->json($planet, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get the planet.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a list of vehicles from SWAPI.
     *
     * @OA\Get(
     *     path="/api/v1/vehicles",
     *     summary="Get a list of vehicles",
     *     tags={"Vehicles"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results per page",
     *         @OA\Schema(
     *             type="integer",
     *             default="10"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Number of results to skip",
     *         @OA\Schema(
     *             type="integer",
     *             default="0"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of vehicles",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function getVehicles(VehicleRequest $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $vehicles = $this->swapiService->getVehicles($limit, $offset);

            return response()->json($vehicles, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting the vehicles.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a vehicle by ID from SWAPI.
     *
     * @OA\Get(
     *     path="/api/v1/vehicles/{id}",
     *     summary="Get a vehicle by ID",
     *     tags={"Vehicles"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the vehicle",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vehicle details",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     *
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function getVehicleById($id)
    {
        try {
            $vehicle = $this->swapiService->getVehicleById($id);

            return response()->json($vehicle, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting the vehicle.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
