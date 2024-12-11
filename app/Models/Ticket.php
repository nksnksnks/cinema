<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'ci_ticket';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'seat_id',
        'bill_id',
        'movie_showtime_id',
        'price',
    ];
    public $timestamps = true;
}
