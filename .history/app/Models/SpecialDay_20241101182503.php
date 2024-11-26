<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDay extends Model
{
    use HasFactory;
    protected $table = 'ci_special_days';

    protected $fillable = [
        'day_type',
        'description',
        'special_day',
        'extra_fee',
    ];
}
