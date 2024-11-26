<?php

namespace App\Http\Controllers\Api\admin;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Repositories\admin\MovieShowtime\MovieShowTimeRepository;
use Illuminate\Http\Request;
use App\Models\MovieShowtime;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
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
    public function movieshowtimeIndex(){
        $movieshowtimes = MovieShowtime::all();
        $movie = Movie::pluck('name','id');
        $room = Room::pluck('name','id');
        return view('admin.movieshowtime.index',compact('movieshowtimes','movie','room'));
    }
    public function movieshowtimeCreate(){
        $config['method'] = 'create';
        $movie = Movie::pluck('name','id');
        // Lấy cinema_id của người dùng đang đăng nhập
        $cinema_id = Auth::user()->cinema_id;
        $cinema = Cinema::find($cinema_id);
        $room = Room::where('cinema_id',$cinema_id)->pluck('name','id');
        return view('admin.movieshowtime.create',compact('config','room','movie','cinema'));
    }
    public function movieshowtimeStore(MovieShowtimeRequest $request)
    {
        try {
            DB::beginTransaction();
    
            // Lấy tất cả dữ liệu từ request
            $data = $request->all();
    
            // Kiểm tra xem showtime có bị trùng thời gian không
            $existingShowtime = MovieShowtime::where('room_id', $data['room_id'])
            ->where('start_date', $data['start_date'])
            ->where(function ($query) use ($data) {
                $query->where('start_time', '<', $data['end_time'])
                    ->where('end_time', '>', $data['start_time']);
            })
            ->exists();

    
            if ($existingShowtime) {
                // Nếu có showtime trùng, hiển thị lỗi và không tạo mới
                return redirect()
                    ->route('movieshowtime.create')
                    ->with('error', 'trùng thời gian');
            }
    
            // Tạo mới MovieShowtime nếu không trùng thời gian
            MovieShowtime::create($data);
    
            DB::commit();
    
            // Redirect về trang tạo showtime và hiển thị thông báo thành công
            return redirect()
                ->route('movieshowtime.create')
                ->with('success', trans('messages.success.success'));
    
        } catch (\Throwable $th) {
            DB::rollBack();
    
            // Nếu có lỗi, redirect lại và hiển thị thông báo lỗi
            return redirect()
                ->route('movieshowtime.create')
                ->with('error', $th->getMessage());
        }
    }
    

    public function movieshowtimeEdit(string $id){
        $movieshowtime = MovieShowtime::find($id);
        $movie = Movie::pluck('name','id');
        // Lấy cinema_id của người dùng đang đăng nhập
        $cinema_id = Auth::user()->cinema_id;
        $cinema = Cinema::find($cinema_id);
        $room = Room::where('cinema_id',$cinema_id)->pluck('name','id');

        $config['method'] = 'edit';
        return view('admin.movieshowtime.create', compact('config','movieshowtime','movie','room','cinema'));
    }
  
    public function movieshowtimeUpdate($id, MovieShowtimeRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $query = MovieShowtime::find($id);
            $query->update($data);
            DB::commit();
            return redirect()
            ->route('movieshowtime.index')
            ->with('success', trans('messages.success.success'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()
            ->route('movieshowtime.index')
            ->with('error', $th->getMessage());
        }
    }
    public function movieshowtimeDestroy(string $id){
        MovieShowtime::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa movieshowtime thành công.');
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
