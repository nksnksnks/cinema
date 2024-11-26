<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatType extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ci_seat_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'room_id',
        'seat_type_id',
        'seat_code',
        
    ];
    public $timestamps = true;
}
