<?php

namespace App\Repositories\user\MovieShowTime;

use App\Models\MovieShowtime;

class MovieShowTimeRepository{
    public function getShowTime($cinemaId, $movieId, $date)
    {
        $data = MovieShowtime::join('ci_room', 'ci_movie_show_time.room_id', '=', 'ci_room.id')
            ->where('ci_room.cinema_id', '=', $cinemaId)
            ->where('ci_movie_show_time.movie_id' , '=', $movieId)
            ->where('ci_movie_show_time.start_date', '=', $date)
            ->orderBy('ci_movie_show_time.start_time', 'ASC')
            ->get();
        return $data;
    }
}
