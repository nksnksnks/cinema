<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Http\Requests\admin\MovieRequest;
use App\Enums\Constant;
use Cloudinary\Cloudinary;

/**
 * @OA\Schema(
 *     schema="Movie",
 *     type="object",
 *     required={"id", "name", "description", "duration", "date"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Phim Hành Động Mới"),
 *     @OA\Property(property="slug", type="string", example="phim-hanh-dong-moi"),
 *     @OA\Property(property="country_id", type="integer", example=1),
 *     @OA\Property(property="rated_id", type="integer", example=1),
 *     @OA\Property(property="avatar", type="string", example="https://example.com/avatar.jpg"),
 *     @OA\Property(property="poster", type="string", example="https://example.com/poster.jpg"),
 *     @OA\Property(property="trailer_url", type="string", example="https://youtube.com/trailer"),
 *     @OA\Property(property="duration", type="integer", example=120),
 *     @OA\Property(property="date", type="string", format="date", example="2024-10-10"),
 *     @OA\Property(property="performer", type="string", example="Diễn viên chính"),
 *     @OA\Property(property="director", type="string", example="Đạo diễn nổi tiếng"),
 *     @OA\Property(property="description", type="string", example="Mô tả phim"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-09T12:00:00Z")
 * )
 */
class MovieController extends Controller
{
    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/admin/movies",
     *     tags={"Admin Movies"},
     *     summary="Get all movies",
     *     operationId="getMovies",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Movie")
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
            $movies = Movie::with('movie_genre')->get();
            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => trans('messages.success.success'),
                'data' => $movies
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
     *     path="/api/admin/movies",
     *     tags={"Admin Movies"},
     *     summary="Create a new movie",
     *     operationId="createMovie",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="country_id", type="integer"),
     *             @OA\Property(property="rated_id", type="integer"),
     *             @OA\Property(property="avatar", type="string"),
     *             @OA\Property(property="poster", type="string"),
     *             @OA\Property(property="trailer_url", type="string"),
     *             @OA\Property(property="duration", type="integer"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="performer", type="string"),
     *             @OA\Property(property="director", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="genre_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Examples(
     *                 example="CreateMovieExample",
     *                 summary="Sample movie creation data",
     *                 value={
     *                     "name": "Phim Hành Động Mới",
     *                     "slug": "phim-hanh-dong-moi",
     *                     "country_id": 1,
     *                     "rated_id": 1,
     *                     "avatar": "https://example.com/avatar.jpg",
     *                     "poster": "https://example.com/poster.jpg",
     *                     "trailer_url": "https://youtube.com/trailer",
     *                     "duration": 120,
     *                     "date": "2024-10-10",
     *                     "performer": "Diễn viên chính",
     *                     "director": "Đạo diễn nổi tiếng",
     *                     "description": "Mô tả phim",
     *                     "genre_ids": {1, 2}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Movie")
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
    public function store(MovieRequest $request)
    {
        try {
            DB::beginTransaction();

            // Kiểm tra genre_ids có tồn tại không
            foreach ($request->input('genre_ids') as $genreId) {
                if (!Genre::find($genreId)) {
                    return response()->json([
                        'status' => Constant::FALSE_CODE,
                        'message' => "Genre ID {$genreId} does not exist."
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            // Upload ảnh avatar lên Cloudinary
            $avatarUrl = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarResult = cloudinary()->upload($avatar->getRealPath(), [
                    'folder' => 'movie',
                    'upload_preset' => 'movie-upload',
                ]);
                $avatarUrl = $avatarResult->getSecurePath(); // Lấy URL an toàn
            }

            // Upload ảnh poster lên Cloudinary
            $posterUrl = null;
            if ($request->hasFile('poster')) {
                $poster = $request->file('poster');
                $posterResult = cloudinary()->upload($poster->getRealPath(), [
                    'folder' => 'movie',
                    'upload_preset' => 'movie-upload',
                ]);
                $posterUrl = $posterResult->getSecurePath();
            }

            // Tạo phim mới
            $movie = Movie::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'genre_id' => $request->input('genre_ids')[0],
                'country_id' => $request->input('country_id'),
                'rated_id' => $request->input('rated_id'),
                'avatar' => $avatarUrl,
                'poster' => $posterUrl,
                'trailer_url' => $request->input('trailer_url'),
                'duration' => $request->input('duration'),
                'date' => $request->input('date'),
                'performer' => $request->input('performer'),
                'director' => $request->input('director'),
                'description' => $request->input('description'),
                'status' => 1
            ]);

            // Lưu tất cả genre_id vào bảng ci_movie_genre sử dụng attach
            $movie->movie_genre()->attach($request->input('genre_ids'));

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'Movie created successfully',
                'data' => $movie
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/admin/movies/{id}",
     *     tags={"Admin Movies"},
     *     summary="Get a movie by ID",
     *     operationId="getMovieById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of movie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Movie")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Movie not found.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $movie = Movie::with('movie_genre')->find($id);

        if (!$movie) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Movie not found.',
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => 'Movie retrieved successfully',
            'data' => $movie
        ]);
    }

    /**
     * @author quynhndmq
     * @OA\Put(
     *     path="/api/admin/movies/{id}",
     *     tags={"Admin Movies"},
     *     summary="Update a movie",
     *     operationId="updateMovie",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of movie to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="country_id", type="integer"),
     *             @OA\Property(property="rated_id", type="integer"),
     *             @OA\Property(property="avatar", type="string"),
     *             @OA\Property(property="poster", type="string"),
     *             @OA\Property(property="trailer_url", type="string"),
     *             @OA\Property(property="duration", type="integer"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="performer", type="string"),
     *             @OA\Property(property="director", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="genre_ids", type="array", @OA\Items(type="integer")),
     *             @OA\Examples(
     *                 example="UpdateMovieExample",
     *                 summary="Sample movie update data",
     *                 value={
     *                     "name": "Phim Hành Động Mới Cập Nhật",
     *                     "slug": "phim-hanh-dong-moi-cap-nhat",
     *                     "country_id": 1,
     *                     "rated_id": 1,
     *                     "avatar": "https://example.com/avatar_updated.jpg",
     *                     "poster": "https://example.com/poster_updated.jpg",
     *                     "trailer_url": "https://youtube.com/trailer_updated",
     *                     "duration": 130,
     *                     "date": "2024-10-12",
     *                     "performer": "Diễn viên chính cập nhật",
     *                     "director": "Đạo diễn nổi tiếng cập nhật",
     *                     "description": "Mô tả phim cập nhật",
     *                     "genre_ids": {1, 2}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Movie")
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
    public function update(MovieRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $movie = Movie::findOrFail($id);

            // Lưu đường dẫn ảnh cũ
            $oldAvatar = $movie->avatar;
            $oldPoster = $movie->poster;
            if ($oldAvatar) {
                $path = parse_url($oldAvatar, PHP_URL_PATH);
                $parts = explode('/movie/', $path);
                $avatarPart = 'movie/' . pathinfo($parts[1], PATHINFO_FILENAME); // 'avatar/khx9uvzvexda7dniu5sa'
            }
            if ($oldPoster) {
                $path = parse_url($oldPoster, PHP_URL_PATH);
                $parts = explode('/movie/', $path);
                $posterPart = 'movie/' . pathinfo($parts[1], PATHINFO_FILENAME); // 'avatar/khx9uvzvexda7dniu5sa'
            }
            // Cập nhật thông tin phim
            $movie->update($request->only([
                'name',
                'slug',
                'country_id',
                'rated_id',
                'trailer_url',
                'duration',
                'date',
                'performer',
                'director',
                'description',
                'status'
            ]));

            // Xử lý upload avatar nếu có
            if ($request->hasFile('avatar')) {
                $avatarResult = cloudinary()->upload($request->file('avatar')->getRealPath(), [
                    'folder' => 'movie',
                    'upload_preset' => 'movie-upload',
                ]);
                $movie->avatar = $avatarResult->getSecurePath();

                // Xóa ảnh cũ trên Cloudinary
                if ($oldAvatar) {
                    cloudinary()->destroy($avatarPart); // Xóa ảnh cũ
                }
            } else {
                $movie->avatar = $oldAvatar;
            }

            // Xử lý upload poster nếu có
            if ($request->hasFile('poster')) {
                $posterResult = cloudinary()->upload($request->file('poster')->getRealPath(), [
                    'folder' => 'movie',
                    'upload_preset' => 'movie-upload',
                ]);
                $movie->poster = $posterResult->getSecurePath();

                // Xóa ảnh cũ trên Cloudinary
                if ($oldPoster) {
                    cloudinary()->destroy($posterPart); // Xóa ảnh cũ
                }
            } else {
                $movie->poster = $oldPoster;
            }

            // Lưu thông tin phim
            $movie->save();

            // Sử dụng sync để cập nhật mối quan hệ giữa phim và thể loại
            $movie->movie_genre()->sync($request->input('genre_ids'));

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'Movie updated successfully',
                'data' => $movie
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    /**
     * @author quynhndmq
     * @OA\Delete(
     *     path="/api/admin/movies/{id}",
     *     tags={"Admin Movies"},
     *     summary="Delete a movie",
     *     operationId="deleteMovie",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of movie to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Movie deleted successfully",
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

            $movie = Movie::findOrFail($id);
            $oldAvatar = $movie->avatar;
            $oldPoster = $movie->poster;
            if ($oldAvatar) {
                $path = parse_url($oldAvatar, PHP_URL_PATH);
                $parts = explode('/movie/', $path);
                $avatarPart = 'movie/' . pathinfo($parts[1], PATHINFO_FILENAME); // 'avatar/khx9uvzvexda7dniu5sa'
                cloudinary()->destroy($avatarPart);
            }
            if ($oldPoster) {
                $path = parse_url($oldPoster, PHP_URL_PATH);
                $parts = explode('/movie/', $path);
                $posterPart = 'movie/' . pathinfo($parts[1], PATHINFO_FILENAME); // 'avatar/khx9uvzvexda7dniu5sa'
                cloudinary()->destroy($posterPart);
            }

            // Xóa các genre liên quan
            Movie_Genre::where('movie_id', $movie->id)->delete();

            $movie->delete();

            DB::commit();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => 'Movie deleted successfully',
                'data' => []
            ], Response::HTTP_OK); // Sử dụng mã trạng thái 200 OK
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => Constant::SUCCESS_CODE,
                'message' => $th->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/app/movieBygenre/{genre_id}",
     *     tags={"User Movies"},
     *     summary="Get a movie by genre",
     *     operationId="getMovieByGenre",
     *     @OA\Parameter(
     *         name="genre_id",
     *         in="path",
     *         description="ID of movie",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Movie")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Movie not found.")
     *         )
     *     )
     * )
     */
    public function getMovieByGenre($genre_id) // get movie by genre 
    {
        if ($genre_id == 0) {
            $movies = Movie::with('movie_genre')->where('status', 1)->get();
        } else {
            // Tìm tất cả movie_id từ bảng ci_movie_genre dựa trên genre_id
            $movies = Movie::with('movie_genre')->whereHas('movie_genre', function ($query) use ($genre_id) {
                $query->where('genre_id', $genre_id);
            })->where('status', 1)->get();
        }


        // Trả về danh sách phim dạng JSON 
        if (!$movies) {
            return response()->json([
                'status' => Constant::FALSE_CODE,
                'message' => 'Movie not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => Constant::SUCCESS_CODE,
            'message' => 'Movie retrieved successfully',
            'data' => $movies
        ]);
    }

    /**
     * @author quynhndmq
     * @OA\Get(
     *     path="/api/app/movieBystatus",
     *     tags={"User Movies"},
     *     summary="Get status movies (đang chiếu , sắp chiếu)",
     *     operationId="getMoviesByStatus",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Movie")
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
    public function getMovieByStatus(Request $request)
    {
        $today = now()->toDateString(); // Lấy ngày hôm nay theo định dạng Y-m-d

        // Lọc phim đang chiếu (status = 1 và ngày khởi chiếu <= hôm nay)
        $currentMovies = Movie::with('movie_genre')->where('status', 1)
            ->where('date', '<=', $today)
            ->get();

        // Lọc phim sắp chiếu (status = 1 và ngày khởi chiếu > hôm nay)
        $upcomingMovies = Movie::with('movie_genre')->where('status', 1)
            ->where('date', '>', $today)
            ->get();

        return response()->json([
            'current_movies' => $currentMovies,
            'upcoming_movies' => $upcomingMovies
        ]);
    }
}
