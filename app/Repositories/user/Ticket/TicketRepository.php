<?php

namespace App\Repositories\user\Ticket;

use App\Models\Bill;
use App\Models\Seat;
use App\Models\Account;
use App\Models\Ticket;
use App\Models\MovieShowtime    ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketConfirmationMail;

class TicketRepository{

    function model(){
        return Ticket::class;
    }

    public function getDatareservation($key){
        list($cinemaId, $showTimeId, $userId, $time) = explode('_', $key, 4);
        $data = Redis::get($cinemaId . '_' . $showTimeId . '_' . $userId);
        return [
            'cinema_id' => $cinemaId,
            'show_time_id' => $showTimeId,
            'user_id' => $userId,
            'seat_list' => $data
        ];
    }

    // public function createBill($key, $amount)
    // {
    //     $data = self::getDatareservation($key);
    //     list($cinemaId, $showTimeId, $userId , $time) = explode('_', $key, 4);
    //     if($data['seat_list']){
    //         $randomNumber = mt_rand(10000, 99999);  // Tạo 5 số ngẫu nhiên
    //         $currentTime = Carbon::now()->format('YmdHis');  // Lấy ngày tháng năm + giờ phút giây (YmdHis)
    //         $ticketCode = $randomNumber . $currentTime;  // Kết hợp cả hai phần
    //         $billId = Bill::create([
    //             'ticket_code' =>  $ticketCode,
    //             'account_id' => (int)$data['user_id'],
    //             'cinema_id' => $data['cinema_id'],
    //             'total' => $amount,
    //             'status' => '1'
    //         ])->id;
    //         foreach (json_decode($data['seat_list']) as $key){
    //             $ticket = Ticket::create([
    //                 'seat_id' => $key,
    //                 'bill_id' => $billId,
    //                 'movie_showtime_id' => (int)$showTimeId,
    //                 'price' => 1000
    //             ]);
    //         }
    //         return $billId;
    //     }
    //     self::cancelReservation($key);
    //     return false;
    // }

   


    public function createBill($key, $amount)
    {
        $data = self::getDatareservation($key);
        list($cinemaId, $showTimeId, $userId , $time) = explode('_', $key, 4);
        if ($data['seat_list']) {
            $randomNumber = mt_rand(10000, 99999);  // Tạo 5 số ngẫu nhiên
            $currentTime = Carbon::now()->timestamp;  // Lấy ngày tháng năm + giờ phút giây (YmdHis)
            $ticketCode = $randomNumber . $currentTime;  // Kết hợp cả hai phần

            // Tạo Bill
            $billId = Bill::create([
                'ticket_code' => $ticketCode,
                'account_id' => (int)$data['user_id'],
                'cinema_id' => $data['cinema_id'],
                'total' => $amount,
                'status' => '1'
            ])->id;

            $seatIds = json_decode($data['seat_list']);
            $seatCodes = []; // Mảng để lưu mã ghế
    
            foreach ($seatIds as $seatId) {
                // Tạo vé cho từng ghế
                Ticket::create([
                    'seat_id' => $seatId,
                    'bill_id' => $billId,
                    'movie_showtime_id' => (int)$showTimeId,
                    'price' => 1000
                ]);
    
                // Lấy mã ghế từ bảng ci_seat
                $seat = Seat::find($seatId);
                if ($seat) {
                    $seatCodes[] = $seat->seat_code; // Thêm mã ghế vào danh sách
                }
            }
            $bill = Bill::find($billId);
            $cinema_name = $bill->cinema->name;
            $total_bill = $bill->total;
            $movieShowtime = MovieShowtime::find($showTimeId);
            $movie_name = $movieShowtime->movie->name;
            $room = $movieShowtime->room->name;
            $start_time = $movieShowtime->start_time;
            $seatListString = implode(', ', $seatCodes); // Chuỗi ghế: "A1, A2, B1"
            // Lấy email người dùng
            $user = Account::find($data['user_id']);
            if ($user && $user->email && $seatListString) {
                // Gửi email cho người dùng
                Mail::to($user->email)->send(new TicketConfirmationMail($user->username, $ticketCode, $seatListString, $cinema_name, $movie_name, $room, $start_time, $total_bill));
            }

            return $billId;
        }

        self::cancelReservation($key);
        return false;
    }

    public function getSeatSold($showTimeId)
    {
        $data = Ticket::where('movie_showtime_id', $showTimeId)
            ->get();
        return $data;
    }

    public static function cancelReservation($key)
    {
        list($cinemaId, $showTimeId, $userId, $time) = explode('_', $key, 4);
        $data = Redis::del($cinemaId . '_' . $showTimeId . '_' . $userId);
        return 0;
    }

}
