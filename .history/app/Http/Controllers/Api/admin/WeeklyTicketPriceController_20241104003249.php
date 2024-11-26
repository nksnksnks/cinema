<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyTicketPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\WeeklyTicketPriceRequest;

/**
 * @OA\Schema(
 *     schema="weekly_ticket_price",
 *     type="object",
 *     required={"id", "name", "description", "extra_fee"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Weekday Price"),
 *     @OA\Property(property="description", type="string", example="Price for weekdays."),
 *     @OA\Property(property="extra_fee", type="integer", example=5000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T12:00:00Z")
 * )
 */
class WeeklyTicketPriceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/weekly-ticket-prices",
     *     tags={"WeeklyTicketPrices"},
     *     summary="Get all weekly ticket prices",
     *     operationId="getWeeklyTicketPrices",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/weekly_ticket_price")
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
        $weeklyTicketPrices = WeeklyTicketPrice::all();
        return response()->json($weeklyTicketPrices);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/weekly-ticket-prices",
     *     tags={"WeeklyTicketPrices"},
     *     summary="Create a new weekly ticket price",
     *     operationId="createWeeklyTicketPrice",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="extra_fee", type="integer"),
     *             @OA\Examples(
     *                 example="CreateWeeklyTicketPriceExample",
     *                 summary="Sample weekly ticket price creation data",
     *                 value={
     *                     "name": "Weekend Price",
     *                     "description": "Price for weekends.",
     *                     "extra_fee": 5000
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Weekly ticket price created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly ticket price created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/weekly_ticket_price")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error.")
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
    public function store(WeeklyTicketPriceRequest $request)
    {
        try {
            DB::beginTransaction();

            $weeklyTicketPrice = WeeklyTicketPrice::create($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Weekly ticket price created successfully',
                'data' => $weeklyTicketPrice
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
     * @OA\Get(
     *     path="/api/admin/weekly-ticket-prices/{weekly_ticket_price}",
     *     tags={"WeeklyTicketPrices"},
     *     summary="Get a weekly ticket price by ID",
     *     operationId="getWeeklyTicketPriceById",
     *     @OA\Parameter(
     *         name="weekly_ticket_price",
     *         in="path",
     *         description="ID of weekly ticket price",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/weekly_ticket_price")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Weekly ticket price not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Weekly ticket price not found.")
     *         )
     *     )
     * )
     */
    public function show(WeeklyTicketPrice $weekly_ticket_price)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Weekly ticket price retrieved successfully',
            'data' => $weekly_ticket_price
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/weekly-ticket-prices/{weekly_ticket_price}",
     *     tags={"WeeklyTicketPrices"},
     *     summary="Update a weekly ticket price",
     *     operationId="updateWeeklyTicketPrice",
     *     @OA\Parameter(
     *         name="weekly_ticket_price",
     *         in="path",
     *         description="ID of weekly ticket price to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="extra_fee", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Weekly ticket price updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Weekly ticket price updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/weekly_ticket_price")
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
    public function update(WeeklyTicketPriceRequest $request, WeeklyTicketPrice $weekly_ticket_price)
    {
        try {
            DB::beginTransaction();

            $weekly_ticket_price->update($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Weekly ticket price updated successfully',
                'data' => $weekly_ticket_price
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
     * @OA\Delete(
     *     path="/api/admin/weekly-ticket-prices/{weekly_ticket_price}",
     *     tags={"WeeklyTicketPrices"},
     *     summary="Delete a weekly ticket price",
     *     operationId="deleteWeeklyTicketPrice",
     *     @OA\Parameter(
     *         name="weekly_ticket_price",
     *         in="path",
     *         description="ID of weekly ticket price to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Weekly ticket price deleted successfully",
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
    public function destroy(WeeklyTicketPrice $weekly_ticket_price)
    {
        try {
            DB::beginTransaction();

            $weekly_ticket_price->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Weekly ticket price deleted successfully',
                'data' => []
            ], Response::HTTP_OK);
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
