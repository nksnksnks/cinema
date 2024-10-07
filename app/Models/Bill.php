<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ci_bill';

    const PENDING = 0;

    const PAID = 1;

    const EXPIRED = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'account_id',
        'cinema_id',
        'total',
        'status',
    ];
    public $timestamps = true;

    public function ticket(){
        return $this->hasMany('App\Models\Ticket', 'bill_id', 'id');
    }

    public function account(){
        return $this->belongsTo('App\Models\Account', 'account_id', 'id');
    }

    public function cinema()
    {
        return $this->belongsTo('App\Models\Cinema', 'cinema_id', 'id');
    }
}
