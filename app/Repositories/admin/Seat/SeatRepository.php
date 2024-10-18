<?php

namespace App\Repositories\admin\Seat;

use App\Models\Seat;
use Illuminate\Support\Facades\Hash;

class SeatRepository implements SeatInterface{

    function model(){
        return Seat::class;
    }
    public function creatSeat($request)
    {
        return Seat::create($request);
    }
}
