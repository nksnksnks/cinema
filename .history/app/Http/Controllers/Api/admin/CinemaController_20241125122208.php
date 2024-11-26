<?php

namespace App\Http\Controllers\Api\admin;

use App\Enums\Constant;
use App\Models\Cinema;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CinemaRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CinemaController extends Controller
{

    public function create()
    {
        $config['method'] = 'create';
        return view('admin.cinema.create', compact('config'));
    }

    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/admin/cinema/create",
     *     tags={"Admin Quản lý rạp chiếu phim"},
     *     summary="Tạo mới",
     *     operationId="admin/cinema/create",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="address", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "name": "CinemaEase Hà Đông",
     *                  "address": "Số 10 - Trần Phú - Hà Đông - Hà Nội",
     *                  },
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function createCinema(CinemaRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            Cinema::create($data);
            DB::commit();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function CinemaStore(CinemaRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            Cinema::create($data);
            DB::commit();
            return redirect()
                ->route('cinema.store')
                ->with('success', trans('messages.success.success'));
        } catch (\Throwable $th) {
            // DB::rollBack();
            return redirect()
                ->route('cinema.store')
                ->with('error', $th->getMessage());
        }
        
    }


    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/admin/cinema/update/{id}",
     *     tags={"Admin Quản lý rạp chiếu phim"},
     *     summary="Cập nhật",
     *     operationId="admin/cinema/update",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID cinema",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="address", type="string"),
     *              @OA\Examples(
     *                  summary="Examples",
     *                  example = "Examples",
     *                  value = {
     *                     "name": "CinemaEase Hà Đông",
     *                     "address": "Số 10 - Trần Phú - Hà Đông - Hà Nội",
     *                  },
     *              ),
     *           ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function updateCinema($id, CinemaRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = Cinema::find($id);
            if (!$query) {
                return response()->json([
                    'status' => Constant::FALSE_CODE,
                    'message' => trans('messages.errors.cinema.id_found'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }
            $query->update($data);
            DB::commit();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function updateCinema($id, CinemaRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = Cinema::find($id);
            if (!$query) {
                return response()->json([
                    'status' => Constant::FALSE_CODE,
                    'message' => trans('messages.errors.cinema.id_found'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }
            $query->update($data);
            DB::commit();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => []
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
     * @author son.nk
     * @OA\Get (
     *     path="/api/admin/cinema/get-list",
     *     tags={"Admin Quản lý rạp chiếu phim"},
     *     summary="Lấy danh sách",
     *     operationId="admin/cinema/get-list",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function getListCinema(){
        try {
            $data = Cinema::all();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $data
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
     * @author son.nk
     * @OA\Get (
     *     path="/api/admin/cinema/get/{id}",
     *     tags={"Admin Quản lý rạp chiếu phim"},
     *     summary="Lấy theo id",
     *     operationId="admin/cinema/get",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID cinema",
     *          required=true,
     *               @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function getCinema($id){
        try {
            $data = Cinema::find($id);
            if (!$data) {
                return response()->json([
                    'status' => Constant::FALSE_CODE,
                    'message' => trans('messages.errors.cinema.id_found'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $data
            ], Constant::SUCCESS_CODE);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
