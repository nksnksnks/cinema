<?php
namespace app\Http\Controllers\Api\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Cinema;
use App\Models\Account;
use App\Models\Movie;
use App\Models\MovieShowTime;
use App\Models\Ticket;
use App\Models\Food;
use App\Models\FoodBill;
use Carbon\Carbon;

use App\Models\FoodBillJoin;

class ThongkeController extends Controller
{

    private function getMonthlyRevenue($cinema_id, $startOfMonth, $endOfMonth)
    {
        $monthlyRevenue = DB::table('ci_bill')
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total');

        return $monthlyRevenue;
    }
    private function getMonthlyRevenueFood($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng doanh thu từ đầu tháng đến ngày hiện tại theo cinema_id
        $monthlyRevenue = DB::table('ci_food_bill_join')
            ->join('ci_bill', 'ci_food_bill_join.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('ci_food_bill_join.created_at', [$startOfMonth, $endOfMonth])
            ->sum('ci_food_bill_join.total');

        return $monthlyRevenue;
    }
    private function getMonthlyFood($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng doanh thu từ đầu tháng đến ngày hiện tại theo cinema_id
        $monthlyRevenue = DB::table('ci_food_bill_join')
            ->join('ci_bill', 'ci_food_bill_join.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('ci_food_bill_join.created_at', [$startOfMonth, $endOfMonth])
            ->sum('quantity');

        return $monthlyRevenue;
    }
    private function getMostMonthlyFood($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng doanh thu từ đầu tháng đến ngày hiện tại theo cinema_id
        $monthlyRevenueId = DB::table('ci_food_bill_join')
            ->join('ci_bill', 'ci_food_bill_join.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('ci_food_bill_join.created_at', [$startOfMonth, $endOfMonth])
            ->select('ci_food_bill_join.food_id', DB::raw('COUNT(*) as food_count'))
            ->groupBy('ci_food_bill_join.food_id')
            ->orderByDesc('food_count')
            ->orderBy('ci_food_bill_join.food_id') // Lấy xuất chiếu đầu tiên nếu có số vé bằng nhau
            ->limit(1)
            ->pluck('ci_food_bill_join.food_id')
            ->first();
            if ($monthlyRevenueId) {
                // Lấy thông tin phim từ bảng ci_movie
                $monthlyRevenue = DB::table('ci_foods')
                    ->where('id', $monthlyRevenueId)
                    ->value('name');
            } else {
                $monthlyRevenue = 'Không xác định';
            }
    
            return $monthlyRevenue;   

    }

    private function getMonthlyRevenueMovie($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng doanh thu từ đầu tháng đến ngày hiện tại theo cinema_id, dựa vào bảng ci_ticket
        $monthlyRevenue = DB::table('ci_ticket')
            ->join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->when($cinema_id != 0, fn ($query) => $query->where('ci_bill.cinema_id', $cinema_id))
            ->whereBetween('ci_ticket.created_at', [$startOfMonth, $endOfMonth]) // Sử dụng created_at của ci_ticket
            ->sum('ci_ticket.price'); // Tính tổng price từ ci_ticket

        return $monthlyRevenue;
    }

    private function getMonthlyTickets($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng số vé trong tháng theo cinema_id
        $monthlyTickets = DB::table('ci_ticket')
            ->join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->when($cinema_id != 0, fn ($query) => $query->where('ci_bill.cinema_id', $cinema_id))
            ->whereBetween('ci_ticket.created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return $monthlyTickets;
    }

    private function getMostWatchedMovieInMonth($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tìm phim được xem nhiều nhất trong tháng theo cinema_id
        $mostWatchedMovieId = DB::table('ci_ticket')
            ->join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id') // Join với bảng ci_bill
            ->join('ci_movie_show_time', 'ci_ticket.movie_showtime_id', '=', 'ci_movie_show_time.id') // Join với bảng ci_movie_show_time
            ->select('ci_movie_show_time.movie_id', DB::raw('COUNT(*) as ticket_count'))
            ->when($cinema_id != 0, fn ($query) => $query->where('ci_bill.cinema_id', $cinema_id))
            ->whereBetween('ci_ticket.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('ci_movie_show_time.movie_id')
            ->orderByDesc('ticket_count')
            ->orderBy('ci_movie_show_time.movie_id') // Lấy xuất chiếu đầu tiên nếu có số vé bằng nhau
            ->limit(1)
            ->pluck('ci_movie_show_time.movie_id')
            ->first();

        if ($mostWatchedMovieId) {
            // Lấy thông tin phim từ bảng ci_movie
            $mostWatchedMovie = DB::table('ci_movie')
                ->where('id', $mostWatchedMovieId)
                ->value('name');
        } else {
            $mostWatchedMovie = 'Không xác định';
        }

        return $mostWatchedMovie;
    }

    private function getNewUsersThisMonth($cinema_id,$startOfMonth,$endOfMonth)
    {
        // Tính tổng số người dùng mới trong tháng của chi nhánh
        $newUsers = DB::table('ci_account')
        ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return $newUsers;
    }


    public function index(Request $request)
{
    
    // Lấy giá trị start_date và end_date từ request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Kiểm tra ngày bắt đầu và ngày kết thúc
    if (!$startDate || !$endDate) {
        $startDate = now()->startOfMonth()->toDateString(); // Ngày đầu tháng
        $endDate = now()->toDateTimeString(); // Ngày hiện tại
        $endDate1 = now()->toDateString(); // Ngày hiện tại
    } else {
        $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
        $endDate1 = date('Y-m-d', strtotime($endDate));
    }

    $cinema_id = Auth::user()->cinema_id;

    // Tính tổng doanh thu trong tháng
    $monthlyRevenue = $this->getMonthlyRevenue($cinema_id, $startDate, $endDate);

    // Tính tổng số vé trong tháng
    $monthlyTickets = $this->getMonthlyTickets($cinema_id, $startDate, $endDate);

    // Tìm phim được xem nhiều nhất trong tháng
    $mostWatchedMovieInMonth = $this->getMostWatchedMovieInMonth($cinema_id, $startDate, $endDate);

    $NewUsersThisMonth = $this->getNewUsersThisMonth($cinema_id, $startDate, $endDate);

    // Kiểm tra khoảng cách giữa start_date và end_date
    $startDateTime = new \DateTime($startDate);
    $endDateTime = new \DateTime($endDate);
    $interval = $startDateTime->diff($endDateTime);

    if ($interval->y >= 1) {
        // Lấy danh sách doanh thu theo từng năm nếu khoảng thời gian > 1 năm
        $statistics = DB::table('ci_bill')
            ->selectRaw("YEAR(created_at) as year, SUM(total) as total_revenue")
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->map(function ($data) {
                return [
                    'date' => $data->year,
                    'total_revenue' => $data->total_revenue,
                    'total_tickets' => null,
                    'most_watched_movie' => null,
                ];
            });
    } elseif ($interval->days > 30) {
        // Lấy danh sách doanh thu theo từng tháng nếu khoảng thời gian > 30 ngày
        $statistics = DB::table('ci_bill')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total_revenue")
            ->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($data) {
                return [
                    'date' => $data->month,
                    'total_revenue' => $data->total_revenue,
                    'total_tickets' => null,
                    'most_watched_movie' => null,
                ];
            });
    } else {
        // Lấy danh sách các ngày giữa khoảng thời gian
        $dates = DB::table('ci_bill')->when($cinema_id != 0, fn ($query) => $query->where('cinema_id', $cinema_id))
            ->selectRaw("DATE(created_at) as date")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $statistics = $dates->map(function ($date) {
            $currentDate = $date->date;

            // Tổng doanh thu trong ngày
            $totalRevenue = DB::table('ci_bill')
                ->whereDate('created_at', $currentDate)
                ->sum('total');

            // Tổng số vé bán trong ngày
            $totalTickets = DB::table('ci_ticket')
                ->whereDate('created_at', $currentDate)
                ->count();

            // Phim được xem nhiều nhất trong ngày
            $mostWatchedMovieId = DB::table('ci_ticket')
                ->select('movie_showtime_id', DB::raw('COUNT(*) as ticket_count'))
                ->whereDate('created_at', $currentDate)
                ->groupBy('movie_showtime_id')
                ->orderByDesc('ticket_count')
                ->orderBy('movie_showtime_id') // Lấy xuất chiếu đầu tiên nếu có số vé bằng nhau
                ->limit(1)
                ->pluck('movie_showtime_id')
                ->first();

            $mostWatchedMovie = null;

            if ($mostWatchedMovieId) {
                $mostWatchedMovie = DB::table('ci_movie_show_time')
                    ->join('ci_ticket', 'ci_ticket.movie_showtime_id', '=', 'ci_movie_show_time.id')
                    ->join('ci_movie', 'ci_movie.id', '=', 'ci_movie_show_time.movie_id')
                    ->where('ci_movie_show_time.id', $mostWatchedMovieId)
                    ->value('ci_movie.name');
            }

            return [
                'date' => $currentDate,
                'total_revenue' => $totalRevenue,
                'total_tickets' => $totalTickets,
                'most_watched_movie' => $mostWatchedMovie ?? 'Không xác định',
            ];
        });
    }

    return view('admin.dashboard.home.index', compact('statistics', 'startDate', 'endDate1', 'monthlyRevenue', 'monthlyTickets', 'mostWatchedMovieInMonth', 'NewUsersThisMonth'));
}


    public function tkmovie(Request $request)
    {
        $movies = Movie::all();
        // Lấy giá trị start_date và end_date từ request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        

        // Kiểm tra ngày bắt đầu và ngày kết thúc
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString(); // Ngày đầu tháng
            $endDate = now()->toDateTimeString(); // Ngày hiện tại
            $endDate1 = now()->toDateString(); // Ngày hiện tại
        }else{
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
        }

        $cinema_id = Auth::user()->cinema_id;
            // Tính tổng doanh thu trong tháng
            $monthlyRevenue = $this->getMonthlyRevenueMovie($cinema_id,$startDate,$endDate);
            
            // Tính tổng số vé trong tháng
            $monthlyTickets = $this->getMonthlyTickets($cinema_id,$startDate,$endDate);
            
            // Tìm phim được xem nhiều nhất trong tháng
            $mostWatchedMovieInMonth = $this->getMostWatchedMovieInMonth($cinema_id,$startDate,$endDate);
    
            $NewUsersThisMonth = $this->getNewUsersThisMonth($cinema_id,$startDate,$endDate);


        // Lấy danh sách movie show times trong khoảng thời gian, thuộc cinema_id và có room thuộc cinema đó
        $movieShowTimes = MovieShowTime::whereBetween('start_date', [$startDate, $endDate])
        ->when($cinema_id != 0, fn ($query) =>
            $query->whereHas('room', fn ($subQuery) =>
                $subQuery->whereHas('cinema', fn ($subSubQuery) =>
                    $subSubQuery->where('id', $cinema_id)
                )
            )
        )
        ->get();

        $movieRevenues = [];

        foreach ($movieShowTimes as $showTime) {
            // Lấy thông tin phim
            $movie = Movie::find($showTime->movie_id);

            // Tính tổng tiền vé cho mỗi movie_showtime_id
            $totalRevenue = Ticket::join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id')
                ->where('ci_bill.cinema_id', $cinema_id)
                ->where('ci_ticket.movie_showtime_id', $showTime->id)
                ->sum('ci_ticket.price');

            // Tính tổng số vé bán ra cho mỗi movie_showtime_id
            $totalTickets = Ticket::join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id')
                ->where('ci_bill.cinema_id', $cinema_id)
                ->where('ci_ticket.movie_showtime_id', $showTime->id)
                ->count();

            // Nếu movie_id đã tồn tại trong mảng, cộng dồn doanh thu và số vé
            if (isset($movieRevenues[$showTime->movie_id])) {
                $movieRevenues[$showTime->movie_id]['total_revenue'] += $totalRevenue;
                $movieRevenues[$showTime->movie_id]['total_tickets'] += $totalTickets;
            } else {
                // Nếu movie_id chưa tồn tại, thêm mới vào mảng
                $movieRevenues[$showTime->movie_id] = [
                    'movie_name' => $movie->name,
                    'total_revenue' => $totalRevenue,
                    'total_tickets' => $totalTickets,
                ];
            }
        }
       
        // Sắp xếp mảng theo doanh thu giảm dần
        usort($movieRevenues, function ($a, $b) {
            return $b['total_revenue'] - $a['total_revenue'];
        });

        return view('admin.dashboard.home.tkmovie', compact('movieRevenues', 'startDate', 'endDate1', 'monthlyRevenue', 'monthlyTickets', 'mostWatchedMovieInMonth', 'NewUsersThisMonth', 'movies'));
    }
    
    public function getMovieStatistics(Request $request)
{
    $movieId = $request->input('movie_id');
    $cinemaId = Auth::user()->cinema_id;

    // Lấy ngày bắt đầu chiếu phim (dựa vào ngày tạo hóa đơn đầu tiên)
    $startDate = DB::table('ci_bill')
        ->join('ci_ticket', 'ci_bill.id', '=', 'ci_ticket.bill_id')
        ->join('ci_movie_show_time', 'ci_ticket.movie_showtime_id', '=', 'ci_movie_show_time.id')
        ->where('ci_movie_show_time.movie_id', $movieId)
        ->where('ci_bill.cinema_id', $cinemaId)
        ->min('ci_movie_show_time.start_date');

    // Nếu không tìm thấy ngày bắt đầu, trả về mảng rỗng
    if (!$startDate) {
        return response()->json([
            'statistics' => [],
            'totalRevenue' => 0,
            'totalTickets' => 0
        ]);
    }

    $startDate = Carbon::parse($startDate)->toDateString();
    $endDate = now()->toDateString(); // Ngày hiện tại

    // Truy vấn thống kê doanh thu và số vé bán được theo ngày
    $dailyStatistics = DB::table('ci_ticket')
        ->join('ci_bill', 'ci_ticket.bill_id', '=', 'ci_bill.id')
        ->join('ci_movie_show_time', 'ci_ticket.movie_showtime_id', '=', 'ci_movie_show_time.id')
        ->where('ci_bill.cinema_id', $cinemaId)
        ->where('ci_movie_show_time.movie_id', $movieId)
        ->whereBetween(DB::raw('DATE(ci_ticket.created_at)'), [$startDate, $endDate])
        ->selectRaw(
            "DATE(ci_ticket.created_at) as date, " .
            "SUM(ci_ticket.price) as daily_revenue, " .
            "COUNT(ci_ticket.id) as daily_tickets" // Thêm trường đếm số vé
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Tính tổng doanh thu và tổng số vé
    $totalRevenue = $dailyStatistics->sum('daily_revenue');
    $totalTickets = $dailyStatistics->sum('daily_tickets');

    // Format dữ liệu cho biểu đồ
    $statistics = $dailyStatistics->map(function ($data) {
        return [
            'date' => $data->date,
            'daily_revenue' => $data->daily_revenue,
            'daily_tickets' => $data->daily_tickets // Thêm số vé bán được vào data
        ];
    });

    return response()->json([
        'statistics' => $statistics,
        'totalRevenue' => $totalRevenue,
        'totalTickets' => $totalTickets
    ]);
}



    public function tkfood(Request $request)
    {
        // Lấy giá trị start_date và end_date từ request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Kiểm tra ngày bắt đầu và ngày kết thúc
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString(); // Ngày đầu tháng
            $endDate = now()->toDateTimeString(); // Ngày hiện tại
            $endDate1 = now()->toDateString(); // Ngày hiện tại
        }else{
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
        }

        $cinema_id = Auth::user()->cinema_id;

        // Lấy tổng doanh thu và số lượng bán của từng món ăn
        $foodStats = DB::table('ci_food_bill_join')
            ->join('ci_bill', 'ci_food_bill_join.bill_id', '=', 'ci_bill.id')
            ->join('ci_foods', 'ci_food_bill_join.food_id', '=', 'ci_foods.id') // Join với bảng ci_food để lấy thông tin món ăn (nếu cần)
            ->where('ci_bill.cinema_id', $cinema_id)
            ->whereBetween('ci_bill.created_at', [$startDate, $endDate]) // Dùng ci_bill.created_at để lọc thời gian
            ->select(
                'ci_food_bill_join.food_id',
                'ci_foods.name as food_name', // Lấy tên món ăn (nếu cần)
                DB::raw('SUM(ci_food_bill_join.quantity) as total_quantity'),
                DB::raw('SUM(ci_food_bill_join.total) as total_revenue')
            )
            ->groupBy('ci_food_bill_join.food_id', 'food_name')
            ->get();

        // Tính tổng doanh thu từ tất cả các món ăn
        $totalRevenue = $foodStats->sum('total_revenue');

        // Lấy tổng số lượng bán của tất cả các món ăn (nếu cần)
        $totalQuantity = $foodStats->sum('total_quantity');
        
        // Lấy món ăn bán chạy nhất (nếu cần)
        $bestSellingFood = $foodStats->sortByDesc('total_quantity')->first();

        // Các hàm khác (nếu bạn vẫn cần dùng)
        $monthlyRevenue = $this->getMonthlyRevenueFood($cinema_id,$startDate,$endDate); // Hàm này bạn tự kiểm tra lại, có thể không cần thiết nữa
        $monthlyTickets = $this->getMonthlyFood($cinema_id,$startDate,$endDate); // Hàm này bạn tự kiểm tra lại, có thể không cần thiết nữa
        $mostWatchedMovieInMonth = $this->getMostMonthlyFood($cinema_id,$startDate,$endDate); // Hàm này bạn tự kiểm tra lại, có thể không cần thiết nữa
        $NewUsersThisMonth = $this->getNewUsersThisMonth($cinema_id,$startDate,$endDate); // Hàm này bạn tự kiểm tra lại, có thể không cần thiết nữa

        return view('admin.dashboard.home.tkfood', compact('startDate', 'endDate1', 'foodStats', 'totalRevenue', 'totalQuantity', 'bestSellingFood', 'monthlyRevenue', 'monthlyTickets', 'mostWatchedMovieInMonth', 'NewUsersThisMonth'));
    }
}
