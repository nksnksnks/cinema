<?php

namespace App\Repositories\user\Movie;

use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Evaluate;

class MovieRepository
{
    public function getMovieDetail($movieId, $accountId = null){
        $query = Movie::with(['movie_genre', 'country', 'rated'])->where('status', 1);
        $movie = Movie::with('movie_genre','rated')->find($movieId);
        $ticket = Ticket::select('ci_ticket.*')
            ->join('ci_movie_show_time as st', 'st.id', '=', 'ci_ticket.movie_showtime_id')
            ->join('ci_bill as b', 'b.id', '=', 'ci_ticket.bill_id')
            ->where('b.account_id', $accountId)
            ->where('st.movie_id', $movieId)
            ->count();
        $evaluate = Evaluate::where('movie_id', $movieId)->where('account_id', $accountId)->first();
        $movie['isEva'] = $evaluate ? true : false;
        $movie['seen_status'] = 0;
        if($ticket > 0)
            $movie['seen_status'] = 1;
        return $movie;
    }
}
