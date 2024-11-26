<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Enums\Constant;
use App\Http\Requests\admin\RatedRequest;
/**
 * @OA\Schema(
 *     schema="rated",
 *     type="object",
 *     required={"id", "name", "description"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="T18"),
 *     @OA\Property(property="description", type="string", example="T18 - Phim được phổ biến đến người xem từ đủ 18 tuổi trở lên (18+)"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T12:00:00Z")
 * )
 */
class RatedController extends Controller
{
    
    public function countryIndex(){
        $countries = Rated::all();
        return view('admin.country.index',compact('countries'));
    }
    public function countryCreate(){
        $config['method'] = 'create';
        return view('admin.country.create',compact('config'));
    }
    public function countryStore(CountryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            Rated::create($data);
            DB::commit();
            return redirect()
                ->route('country.create')
                ->with('success', trans('messages.success.success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->route('country.create')
                ->with('error', $th->getMessage());
        }
        
    }

    public function countryEdit(string $id){
        $country = Rated::find($id);
        $config['method'] = 'edit';
        return view('admin.country.create', compact('config','country'));
    }
  
    public function countryUpdate($id, CountryRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = Rated::find($id);
            $query->update($data);
            DB::commit();
            return redirect()
            ->route('country.index')
            ->with('success', trans('messages.success.success'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
            ->route('country.index')
            ->with('error', $th->getMessage());
        }
    }
    public function countryDestroy(string $id){
        Rated::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa country thành công.');
    }

    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/admin/rateds",
     *     tags={"Admin Rateds"},
     *     summary="Get all rateds",
     *     operationId="getrateds",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/rated")
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
        try {
            $rateds = Rated::all();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $rateds
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @author quynhndmq
     * @OA\Post(
     *     path="/api/admin/rateds",
     *     tags={"Admin Rateds"},
     *     summary="Create a new rated",
     *     operationId="createrated",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Examples(
     *                 example="CreateratedExample",
     *                 summary="Sample rated creation data",
     *                 value={
     *                     "name": "18+",
     *                     "description": "T18 - Phim được phổ biến đến người xem từ đủ 18 tuổi trở lên (18+)"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="rated created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="rated created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/rated")
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
    public function store(RatedRequest $request)
    {
        try {
            DB::beginTransaction();

            $rated = Rated::create($request->all());

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'rated created successfully',
                'data' => $rated
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
     *     path="/api/admin/rateds/{id}",
     *     tags={"Admin Rateds"},
     *     summary="Get a rated by ID",
     *     operationId="getratedById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rated",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/rated")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="rated not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="rated not found.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $rated = Rated::find($id);
        // Route Model Binding nên không cần find('id') mà truyền thẳng object vào hàm
        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => 'rated retrieved successfully',
            'data' => $rated
        ]);
    }

    /**
     * @author quynhndmq
     * @OA\Put(
     *     path="/api/admin/rateds/{id}",
     *     tags={"Admin Rateds"},
     *     summary="Update a rated",
     *     operationId="updaterated",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rated to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Examples(
     *                 example="UpdateratedExample",
     *                 summary="Sample rated update data",
     *                 value={
     *                     "name": "T13",
     *                     "description": "T13 - Phim được phổ biến đến người xem từ đủ 13 tuổi trở lên (13+)"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="rated updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="rated updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/rated")
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
    public function update(RatedRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $rated = Rated::findOrFail($id);
            $rated->update($request->all());

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'rated updated successfully',
                'data' => $rated
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
     *     path="/api/admin/rateds/{id}",
     *     tags={"Admin Rateds"},
     *     summary="Delete a rated",
     *     operationId="deleterated",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of rated to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="rated deleted successfully",
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
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $rated = Rated::findOrFail($id);
            $rated->delete();

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'rated deleted successfully',
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
