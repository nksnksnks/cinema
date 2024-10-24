<?php

namespace App\Repositories\user\Room;

use App\Models\Seat;
use Illuminate\Support\Facades\Hash;

class RoomRepository implements RoomInterface{

    function model(){
        return Seat::class;
    }
}
