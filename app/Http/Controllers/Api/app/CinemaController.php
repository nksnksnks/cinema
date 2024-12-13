<?php

namespace App\Http\Controllers\Api\app;

use App\Enums\Constant;
use App\Models\Cinema;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CinemaRequest;
use App\Repositories\user\MovieShowTime\MovieShowTimeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CinemaController extends Controller{

    public $movieShowTimeRepository;
    public function __construct(
        MovieShowTimeRepository $movieShowTimeRepository
    )
    {
        $this->movieShowTimeRepository = $movieShowTimeRepository;
    }

    /**
     * @author son.nk
     * @OA\Get (
     *     path="/api/app/cinema/get-list",
     *     tags={"App Rạp chiếu phim"},
     *     summary="Lấy danh sách",
     *     operationId="user/cinema/get-list",
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
     *     path="/api/app/show-time/get-list",
     *     tags={"App Rạp chiếu phim"},
     *     summary="Lấy danh sách",
     *     operationId="app/show-time/get-list",
     *     @OA\Parameter(
     *           name="movie_id",
     *           in="query",
     *           description="ID của phim",
     *           required=false,
     *           @OA\Schema(type="integer")
     *      ),
     *     @OA\Parameter(
     *           name="cinema_id",
     *           in="query",
     *           description="ID của rạp chiếu phim",
     *           required=true,
     *           @OA\Schema(type="integer")
     *      ),
     *     @OA\Parameter(
     *           name="date",
     *           in="query",
     *           description="Ngày chiếu (yyyy/mm/dd)",
     *           required=true,
     *           @OA\Schema(type="string", format="date")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success.")
     *         )
     *     ),
     * )
     */

    public function getListShowTime(Request $request)
    {
        try {
            $data = $request->all();
            $data['movie_id'] = $data['movie_id'] ?? null;
            $response = $this->movieShowTimeRepository->getShowTime($data['cinema_id'], $data['movie_id'], $data['date']);

            // Kiểm tra xem có dữ liệu phim và lịch chiếu hay không
            if (!count($response['movie']['movie']['show_time'])) {
                return response()->json([
                    'status' => Constant::FALSE_CODE, // Hoặc false, tùy bạn định nghĩa
                    'message' => 'Không tìm thấy lịch chiếu',
                    'data' => []
                ], 200); // Nên sử dụng 404 Not Found
            }

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $response
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
