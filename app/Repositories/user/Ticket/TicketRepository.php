<?php

namespace App\Repositories\user\Ticket;

use App\Models\Bill;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

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

    public function createBill($key, $amount)
    {
        $data = self::getDatareservation($key);
        list($cinemaId, $showTimeId, $userId , $time) = explode('_', $key, 4);
        if($data['seat_list']){
            $billId = Bill::create([
                'account_id' => (int)$data['user_id'],
                'cinema_id' => $data['cinema_id'],
                'total' => $amount,
                'status' => '1'
            ])->id;
            foreach (json_decode($data['seat_list']) as $key){
                $ticket = Ticket::create([
                    'seat_id' => $key,
                    'bill_id' => $billId,
                    'movie_showtime_id' => (int)$showTimeId,
                    'price' => 1000
                ]);
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
