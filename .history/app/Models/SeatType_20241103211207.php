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
<<<<<<< HEAD
        
        'extra_fee',
=======
        'name',
        'description'
>>>>>>> 26be96429a0b6cf2bbcbe273e9417e4613d38b96
    ];
    public $timestamps = true;
}
