<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'ci_foods';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'image',
        'status',
    ];
    public $timestamps = true;
    public function foodBillJoin()
    {
        return $this->belongsToMany(Bill::class, 'ci_food_bill_join', 'bill_id','food_id') ->withPivot('quantity', 'total');;
    }
}
