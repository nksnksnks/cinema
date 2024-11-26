<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\TimeSlotRequest;

/**
 * @OA\Schema(
 *     schema="timeslot",
 *     type="object",
 *     required={"id", "slot_name", "start_time", "end_time", "extra_fee"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="slot_name", type="string", example="Morning Show"),
 *     @OA\Property(property="start_time", type="string", format="time", example="09:00:00"),
 *     @OA\Property(property="end_time", type="string", format="time", example="11:00:00"),
 *     @OA\Property(property="extra_fee", type="integer", example=5000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T12:00:00Z")
 * )
 */
class TimeSlotController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/timeslots",
     *     tags={"TimeSlots"},
     *     summary="Get all time slots",
     *     operationId="getTimeSlots",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/timeslot")
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
        $timeSlots = TimeSlot::all();
        return response()->json($timeSlots);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/timeslots",
     *     tags={"TimeSlots"},
     *     summary="Create a new time slot",
     *     operationId="createTimeSlot",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="slot_name", type="string"),
     *             @OA\Property(property="start_time", type="string", format="time"),
     *             @OA\Property(property="end_time", type="string", format="time"),
     *             @OA\Property(property="extra_fee", type="integer"),
     *             @OA\Examples(
     *                 example="CreateTimeSlotExample",
     *                 summary="Sample time slot creation data",
     *                 value={
     *                     "slot_name": "Morning Show",
     *                     "start_time": "10:00:00",
     *                     "end_time": "18:00:00",
     *                     "extra_fee": 5000
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Time slot created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Time slot created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/timeslot")
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
    public function store(TimeSlotRequest $request)
    {
        try {
            DB::beginTransaction();

            $timeSlot = TimeSlot::create($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Time slot created successfully',
                'data' => $timeSlot
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
     *     path="/api/admin/timeslots/{timeslot}",
     *     tags={"TimeSlots"},
     *     summary="Get a time slot by ID",
     *     operationId="getTimeSlotById",
     *     @OA\Parameter(
     *         name="timeslot",
     *         in="path",
     *         description="ID of time slot",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/timeslot")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Time slot not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Time slot not found.")
     *         )
     *     )
     * )
     */
    public function show(TimeSlot $timeslot)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Time slot retrieved successfully',
            'data' => $timeSlot
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/timeslots/{timeslot}",
     *     tags={"TimeSlots"},
     *     summary="Update a time slot",
     *     operationId="updateTimeSlot",
     *     @OA\Parameter(
     *         name="timeslot",
     *         in="path",
     *         description="ID of time slot to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="slot_name", type="string"),
     *             @OA\Property(property="start_time", type="string", format="time"),
     *             @OA\Property(property="end_time", type="string", format="time"),
     *             @OA\Property(property="extra_fee", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Time slot updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Time slot updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/timeslot")
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
    public function update(TimeSlotRequest $request, TimeSlot $timeSlot)
    {
        try {
            DB::beginTransaction();

            $timeSlot->update($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Time slot updated successfully',
                'data' => $timeSlot
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
     *     path="/api/admin/timeslots/{timeSlot}",
     *     tags={"TimeSlots"},
     *     summary="Delete a time slot",
     *     operationId="deleteTimeSlot",
     *     @OA\Parameter(
     *         name="timeSlot",
     *         in="path",
     *         description="ID of time slot to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Time slot deleted successfully",
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
    public function destroy(TimeSlot $timeSlot)
    {
        try {
            DB::beginTransaction();

            $timeSlot->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Time slot deleted successfully',
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
