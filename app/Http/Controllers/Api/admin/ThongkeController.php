<?php
namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ThongkeController extends Controller
{
    private function getMonthlyRevenue()
{
    $startOfMonth = now()->startOfMonth()->toDateString();
    $endOfMonth = now()->toDateString();

    // Tính tổng doanh thu từ đầu tháng đến ngày hiện tại
    $monthlyRevenue = DB::table('ci_bill')
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->sum('total');

    return $monthlyRevenue;
}

    private function getMonthlyTickets()
    {
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->toDateString();

        // Tính tổng số vé trong tháng
        $monthlyTickets = DB::table('ci_ticket')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return $monthlyTickets;
    }

    private function getMostWatchedMovieInMonth()
    {
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->toDateString();

        // Tìm phim được xem nhiều nhất trong tháng
        $mostWatchedMovieId = DB::table('ci_ticket')
            ->select('movie_showtime_id', DB::raw('COUNT(*) as ticket_count'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('movie_showtime_id')
            ->orderByDesc('ticket_count')
            ->orderBy('movie_showtime_id') // Lấy xuất chiếu đầu tiên nếu có số vé bằng nhau
            ->limit(1)
            ->pluck('movie_showtime_id')
            ->first();

        if ($mostWatchedMovieId) {
            // Lấy thông tin phim từ movie_show_time và ci_movie
            $mostWatchedMovie = DB::table('ci_movie_show_time')
                ->join('ci_movie', 'ci_movie.id', '=', 'ci_movie_show_time.movie_id')
                ->where('ci_movie_show_time.id', $mostWatchedMovieId)
                ->value('ci_movie.name');
        } else {
            $mostWatchedMovie = 'Không xác định';
        }

        return $mostWatchedMovie;
    }

    private function getNewUsersThisMonth()
    {
        $startOfMonth = now()->startOfMonth()->toDateString(); // Ngày đầu tháng
        $endOfMonth = now()->toDateString(); // Ngày hiện tại

        // Tính tổng số người dùng mới trong tháng
        $newUsers = DB::table('ci_account')
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
            $endDate = now()->toDateString(); // Ngày hiện tại
        }

        // Tính tổng doanh thu trong tháng
        $monthlyRevenue = $this->getMonthlyRevenue();
        
        // Tính tổng số vé trong tháng
        $monthlyTickets = $this->getMonthlyTickets();
        
        // Tìm phim được xem nhiều nhất trong tháng
        $mostWatchedMovieInMonth = $this->getMostWatchedMovieInMonth();

        $NewUsersThisMonth = $this->getNewUsersThisMonth();

        // Lấy danh sách các ngày giữa khoảng thời gian
        $dates = DB::table('ci_bill')
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

        return view('admin.dashboard.home.index', compact('statistics', 'startDate', 'endDate','monthlyRevenue','monthlyTickets','mostWatchedMovieInMonth','NewUsersThisMonth'));
    }
}
