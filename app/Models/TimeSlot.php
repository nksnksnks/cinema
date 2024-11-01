<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $table = 'ci_time_slots';

    protected $fillable = [
        'slot_name',
        'start_time',
        'end_time',
        'extra_fee',
    ];
}
