<?php

namespace App\Http\Controllers\Api\admin;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Repositories\admin\MovieShowtime\MovieShowTimeRepository;
use Illuminate\Http\Request;
use App\Models\MovieShowtime;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\admin\MovieShowtimeRequest;

class MovieShowTimeController extends Controller
{
    public $movieShowTimeRepository;

    public function __construct
    (
        MovieShowTimeRepository $movieShowTimeRepository
    )
    {
        $this->movieShowTimeRepository = $movieShowTimeRepository;
    }
    public function ratedIndex(){
        $rateds = MovieShowtime::all();
        return view('admin.rated.index',compact('rateds'));
    }
    public function ratedCreate(){
        $config['method'] = 'create';
        return view('admin.rated.create',compact('config'));
    }
    public function ratedStore(RatedRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            MovieShowtime::create($data);
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
        $rated = MovieShowtime::find($id);
        $config['method'] = 'edit';
        return view('admin.rated.create', compact('config','rated'));
    }
  
    public function ratedUpdate($id, RatedRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = MovieShowtime::find($id);
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
        MovieShowtime::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa rated thành công.');
    }
    /**
     * @author son.nk
     * @OA\Post (
     *     path="/api/admin/show-time/create",
     *     tags={"Admin Quản lý suất chiếu"},
     *     summary="Tạo mới",
     *     operationId="admin/shiw-time/create",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="movie_id", type="string"),
     *              @OA\Property(property="room_id", type="string"),
     *              @OA\Property(property="start_time", type="time"),
     *              @OA\Property(property="end_time", type="time"),
     *              @OA\Property(property="start_date", type="date"),
     *          @OA\Examples(
     *              summary="Examples",
     *              example = "Examples",
     *              value = {
     *                      "movie_id" : "1",
     *                      "room_id" : "1",
     *                      "start_time": "13:30:00",
     *                      "end_time": "15:50:00",
     *                      "start_date": "2024-10-20"
     *                  }
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
    public function createShowTime(Request $request){
        try {
            DB::beginTransaction();
            if($this->movieShowTimeRepository->getShowtimeCheck($request)){
                return response()->json([
                    'status' => Constant::SUCCESS_CODE,
                    'message' => trans('messages.errors.show_time.exist'),
                    'data' => []
                ], Constant::SUCCESS_CODE);
            }else{
                $this->movieShowTimeRepository->createShowTime($request);
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
}
