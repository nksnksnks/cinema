<?php

namespace App\Repositories\admin\Room;

use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class RoomRepository implements RoomInterface{

    function model(){
        return Room::class;
    }
    public function getRoomCheck($request)
    {
        return Room::where('name', $request['name'])
            ->where('cinema_id', $request['cinema_id'])
            ->count();
    }

    public function createRoom($request)
    {
        $data = $request->all();
        $data['seat_map'] = json_encode($data['seat_map'], true);
        return Room::create($data);
    }
}
