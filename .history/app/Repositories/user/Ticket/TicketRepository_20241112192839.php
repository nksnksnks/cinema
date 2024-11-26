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
    $private
    public function getDatareservation($key){
        list($cinemaId, $showTimeId, $userId) = explode('_', $data, 3);
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
        if($data['seat_list']){
            $billId = Bill::create([
                'account_id' => $data['user_id'],
                'cinema_id' => $data['cinema_id'],
                'total' => $amount,
                'status' => '1'
            ])->id;
            foreach ($data['seat_list'] as $key){
                $ticket = Ticket::create([
                    'seat_id' => $key,
                    'bill_id' => $billId,
                    'movie_show_time' => $data['show_time_id'],
                    'price' => 1000
                ]);
            }
            return $billId;
        }
        return false;
    }

    public function getSeatSold($showTimeId)
    {
        $data = Ticket::where('movie_show_time_id', $showTimeId)
            ->pluck('seat_id')
            ->toArray();
        return $data;
    }

    public function cancelReservation($key)
    {
        list($cinemaId, $showTimeId, $userId) = explode('_', $key, 3);
        $data = Redis::del($cinemaId . '_' . $showTimeId . '_' . $userId);
        return 0;
    }

}
