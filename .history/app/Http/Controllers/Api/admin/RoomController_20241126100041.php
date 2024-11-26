<?php

namespace App\Http\Controllers\Api\admin;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CinemaRequest;
use App\Models\Cinema;
use App\Models\Room;
use App\Repositories\admin\Room\RoomInterface;
use App\Repositories\admin\Seat\SeatInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    public $roomInterface;
    public $seatInterface;
    public function __construct
    (
        RoomInterface $roomInterface,
        SeatInterface $seatInterface
    )
    {
        $this->roomInterface = $roomInterface;
        $this->seatInterface = $seatInterface;
    }

    public function roomIndex(){
        $rooms = Room::all();
        return view('admin.room.index',compact('rooms'));
    }
    public function ratedCreate(){
        $config['method'] = 'create';
        return view('admin.rated.create',compact('config'));
    }
    public function ratedStore(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            Room::create($data);
            DB::commit();
            return redirect()
                ->route('rated.create')
                ->with('success', trans('messages.success.success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
                ->route('rated.create')
                ->with('error', $th->getMessage());
        }
        
    }

    public function ratedEdit(string $id){
        $rated = Room::find($id);
        $config['method'] = 'edit';
        return view('admin.rated.create', compact('config','rated'));
    }
  
    public function ratedUpdate($id, Request $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = Room::find($id);
            $query->update($data);
            DB::commit();
            return redirect()
            ->route('rated.index')
            ->with('success', trans('messages.success.success'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
            ->route('rated.index')
            ->with('error', $th->getMessage());
        }
    }
    public function ratedDestroy(string $id){
        Rated::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa rated thành công.');
    }
    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/admin/room/create",
     *     tags={"Admin Quản lý phòng chiếu"},
     *     summary="Tạo mới",
     *     operationId="admin/room/create",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="cinema_id", type="string"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="seat_map", type="string"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                  "name": "Cinema 1",
     *                  "cinema_id": 1,
     *                  "seat_map": "[[1,1,0],[1,1,1],[1,1,1]]",
     *                  "seat_list": {
     *                          {
     *                               "seat_type_id": 1,
     *                               "seat_code": "A1"
     *                           },
     *                           {
     *                                "seat_type_id": 2,
     *                                "seat_code": "A2"
     *                           },
     *                           {
     *                                 "seat_type_id": 1,
     *                                 "seat_code": "B1"
     *                           },
     *                           {
     *                                  "seat_type_id": 2,
     *                                  "seat_code": "B2"
     *                            },
     *                            {
     *                                  "seat_type_id": 3,
     *                                  "seat_code": "B3"
     *                            },
     *                            {
     *                                   "seat_type_id": 2,
     *                                   "seat_code": "C1"
     *                             },
     *                             {
     *                                  "seat_type_id": 2,
     *                                  "seat_code": "C2"
     *                            },
     *                            {
     *                                   "seat_type_id": 2,
     *                                   "seat_code": "C3"
     *                             },
     *                       }
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
    public function createRoom(Request $request){
        try {
            DB::beginTransaction();
            if($this->roomInterface->getRoomCheck($request)){
                return response()->json([
                    'status' => Constant::FALSE_CODE,
                    'message' => trans('messages.errors.room.exist'),
                    'data' => []
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            $roomId = $this->roomInterface->createRoom($request);
            $seat = $request->all();
            foreach ($seat['seat_list'] as $data){
                $this->seatInterface->creatSeat($data, $roomId);
            }
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
//    /**
//     * @author son.nk
//     * @OA\Post (
//     *     path="/api/admin/cinema/update/{id}",
//     *     tags={"Admin Quản lý rạp chiếu phim"},
//     *     summary="Cập nhật",
//     *     operationId="admin/cinema/update",
//     *     @OA\Parameter(
//     *          name="id",
//     *          in="path",
//     *          description="ID cinema",
//     *          required=true,
//     *          @OA\Schema(type="integer")
//     *      ),
//     *      @OA\RequestBody(
//     *          @OA\JsonContent(
//     *              type="object",
//     *              @OA\Property(property="name", type="string"),
//     *              @OA\Property(property="address", type="string"),
//     *              @OA\Examples(
//     *                  summary="Examples",
//     *                  example = "Examples",
//     *                  value = {
//     *                     "name": "CinemaEase Hà Đông",
//     *                     "address": "Số 10 - Trần Phú - Hà Đông - Hà Nội",
//     *                  },
//     *              ),
//     *           ),
//     *      ),
//     *     @OA\Response(
//     *         response=200,
//     *         description="Success",
//     *             @OA\JsonContent(
//     *              @OA\Property(property="message", type="string", example="Success."),
//     *          )
//     *     ),
//     * )
//     */
//    public function updateCinema($id, CinemaRequest $request){
//        try {
//            DB::beginTransaction();
//            $data = $request->all();
//            $query = Cinema::find($id);
//            if (!$query) {
//                return response()->json([
//                    'status' => Constant::FALSE_CODE,
//                    'message' => trans('messages.errors.cinema.id_found'),
//                    'data' => []
//                ], Constant::SUCCESS_CODE);
//            }
//            $query->update($data);
//            DB::commit();
//            return response()->json([
//                'status' => Constant::SUCCESS_CODE,
//                'message' => trans('messages.success.success'),
//                'data' => []
//            ], Constant::SUCCESS_CODE);
//
//        } catch (\Throwable $th) {
//            return response()->json([
//                'status' => Constant::FALSE_CODE,
//                'message' => $th->getMessage(),
//                'data' => []
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
//    /**
//     * @author son.nk
//     * @OA\Get (
//     *     path="/api/admin/cinema/get-list",
//     *     tags={"Admin Quản lý rạp chiếu phim"},
//     *     summary="Lấy danh sách",
//     *     operationId="admin/cinema/get-list",
//     *     @OA\Response(
//     *         response=200,
//     *         description="Success",
//     *             @OA\JsonContent(
//     *              @OA\Property(property="message", type="string", example="Success."),
//     *          )
//     *     ),
//     * )
//     */
//    public function getListCinema(){
//        try {
//            $data = Cinema::all();
//            return response()->json([
//                'status' => Constant::SUCCESS_CODE,
//                'message' => trans('messages.success.success'),
//                'data' => $data
//            ], Constant::SUCCESS_CODE);
//
//        } catch (\Throwable $th) {
//            return response()->json([
//                'status' => Constant::FALSE_CODE,
//                'message' => $th->getMessage(),
//                'data' => []
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
//
    /**
     * @OA\Get (
     *     path="/api/admin/room/get/{id}",
     *     tags={"Admin Quản lý phòng chiếu"},
     *     summary="Lấy theo id",
     *     operationId="admin/room/get",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID room",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
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
    public function getRoom($id){
        try {
            $data = $this->roomInterface->getRoom($id);
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'success.success',
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
