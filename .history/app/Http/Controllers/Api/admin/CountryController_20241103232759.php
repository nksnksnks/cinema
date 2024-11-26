<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Requests\admin\CountryRequest;

/**
 * @OA\Schema(
 *     schema="country",
 *     type="object",
 *     required={"id", "name", "description"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Việt Nam"),
 *     @OA\Property(property="description", type="string", example="Đất nước yêu hòa bình"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T12:00:00Z")
 * )
 */
class CountryController extends Controller
{

    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/admin/countries",
     *     tags={"Countries"},
     *     summary="Get all countries",
     *     operationId="getcountries",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/country")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    /**
     * @author quynhndmq
     * @OA\Post(
     *     path="/api/admin/countries",
     *     tags={"Countries"},
     *     summary="Create a new country",
     *     operationId="createcountry",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Examples(
     *                 example="CreatecountryExample",
     *                 summary="Sample country creation data",
     *                 value={
     *                     "name": "Việt Nam",
     *                     "description": "Đất nước yêu hòa bình"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="country created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="country created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/country")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name has already been taken.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     )
     * )
     */
    public function store(CountryRequest $request)
    {
        try {
            DB::beginTransaction();

            $country = Country::create($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'country created successfully',
                'data' => $country
            ], Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/admin/countries/{country}",
     *     tags={"Countries"},
     *     summary="Get a country by ID",
     *     operationId="getcountryById",
     *     @OA\Parameter(
     *         name="country",
     *         in="path",
     *         description="ID of country",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/country")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="country not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="country not found.")
     *         )
     *     )
     * )
     */
    public function show(country $country)
    {
        // Route Model Binding nên không cần find('id') mà truyền thẳng object vào hàm
        return response()->json([
            'status' => 'success',
            'message' => 'country retrieved successfully',
            'data' => $country
        ]);
    }

    /**
     * @author quynhndmq
     * @OA\Put(
     *     path="/api/admin/countries/{country}",
     *     tags={"Countries"},
     *     summary="Update a country",
     *     operationId="updatecountry",
     *     @OA\Parameter(
     *         name="country",
     *         in="path",
     *         description="ID of country to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Examples(
     *                 example="UpdatecountryExample",
     *                 summary="Sample country update data",
     *                 value={
     *                     "name": "Mỹ",
     *                     "description": "Đẩt nước phim bom tấn"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="country updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="country updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/country")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name has already been taken.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     )
     * )
     */
    public function update(CountryRequest $request, country $country)
    {
        try {
            DB::beginTransaction();

            $country->update($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'country updated successfully',
                'data' => $country
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @author quynhndmq
     * @OA\Delete(
     *     path="/api/admin/countries/{country}",
     *     tags={"Countries"},
     *     summary="Delete a country",
     *     operationId="deletecountry",
     *     @OA\Parameter(
     *         name="country",
     *         in="path",
     *         description="ID of country to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="country deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     )
     * )
     */
    public function destroy(country $country)
    {
        try {
            DB::beginTransaction();

            $country->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'country deleted successfully',
                'data' => []
            ], Response::HTTP_OK); // Sử dụng 200 OK hoặc 202 Accepted
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
