<?php

namespace App\Repositories\user\MovieShowTime;

use App\Models\Movie;
use App\Models\MovieShowtime;

class MovieShowTimeRepository{
    public function getShowTime($cinemaId, $movieId, $date)
    {
        $data = [];
        if($movieId != null) {
            $movie = Movie::select('ci_movie.*')->join('ci_movie_show_time', 'ci_movie_show_time.movie_id', '=', 'ci_movie.id')
                ->join('ci_room', 'ci_movie_show_time.room_id', '=', 'ci_room.id')
                ->where('ci_movie.id', '=', $movieId)
                ->where('ci_room.cinema_id', '=', $cinemaId)
                ->where('ci_movie_show_time.start_date', $date)
                ->groupBy('ci_movie.id')
                ->first();
            $showTime = MovieShowtime::join('ci_room', 'ci_movie_show_time.room_id', '=', 'ci_room.id')
                ->where('ci_room.cinema_id', '=', $cinemaId)
                ->where('ci_movie_show_time.movie_id', '=', $movieId)
                ->where('ci_movie_show_time.start_date', '=', $date)
                ->orderBy('ci_movie_show_time.start_time', 'ASC')
                ->get();
            if($movie && $showTime)
                $data = self::mapData($movie, $showTime);
        }else{
            $movie = Movie::select('ci_movie.*')->join('ci_movie_show_time', 'ci_movie_show_time.movie_id', '=', 'ci_movie.id')
                ->join('ci_room', 'ci_movie_show_time.room_id', '=', 'ci_room.id')
                ->where('ci_room.cinema_id', '=', $cinemaId)
                ->orderBy('ci_movie.date', 'DESC')
                ->where('ci_movie_show_time.start_date', $date)
                ->groupBy('ci_movie.id')
                ->get();
            foreach ($movie as $key){
                $showTime = MovieShowtime::select('ci_movie_show_time.*')->join('ci_room', 'ci_movie_show_time.room_id', '=', 'ci_room.id')
                    ->where('ci_room.cinema_id', '=', $cinemaId)
                    ->where('ci_movie_show_time.movie_id' , '=', $key->id)
                    ->where('ci_movie_show_time.start_date', '=', $date)
                    ->orderBy('ci_movie_show_time.start_time', 'ASC')
                    ->get();
                $data[] = self::mapData($key, $showTime);
            }
        }
        return $data;
    }
    public function mapData($movie, $showTime)
    {
        $data = $movie;
        $data['show_time'] = $showTime;
        return $data;
    }
}
