<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieShowtime extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ci_movie_show_time';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'movie_id',
        'room_id',
        'start_time',
        'end_time',
        'start_date',
    ];
    public $timestamps = true;

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }
}
