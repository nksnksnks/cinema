<?php

namespace App\Repositories\user\Movie;

use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Evaluate;

class MovieRepository
{
    public function getMovieDetail($movieId, $accountId = null){
        $query = Movie::with(['movie_genre', 'country', 'rated'])->where('status', 1);
        $movies = $query->get();
        $transformedMovies = $movies->map(function ($movie) {
            return [
                "id" => $movie->id,
                "name" => $movie->name,
                "slug" => $movie->slug,
                "genre" => $movie->movie_genre->map(function ($genre) {
                    return [
                        "id" => $genre->id,
                        "name" => $genre->name,
                    // other fields
                    ];
                }),
                "country" => $movie->country ? $movie->country->name : null,
                "rated" => $movie->rated ? $movie->rated->name : null,
                "avatar" => $movie->avatar,
                "poster" => $movie->poster,
                "trailer_url" => $movie->trailer_url,
                "duration" => $movie->duration,
                "date" => $movie->date,
                "performer" => $movie->performer,
                "director" => $movie->director,
                "description" => $movie->description,
                "vote_total" => $movie->vote_total,
                "voting" => $movie->voting,
                "created_at" => $movie->created_at,
                "updated_at" => $movie->updated_at,
                "status" => $movie->status,
                "deleted_at" => $movie->deleted_at,
            ];
        });
        return $transformedMovies;
    }
}
