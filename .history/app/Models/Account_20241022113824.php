<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Account extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $connection = 'mysql';

    protected $table = 'ci_account';

    const NOT_ACTIVE = 0;

    const ACTIVE = 1;

    const USER = 4;

    const ADMIN = 1;

    const MANAGE = 2;

    const STAFF = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role_id',
        'username',
        'email',
        'password',
        'device_token',
        'status',
    ];
    protected $hidden = [
        'password',
    ];
    public $timestamps = true;

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'account_id', 'id');
    }

    public function bill()
    {
        return $this->hasMany('App\Models\Bill', 'bill_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
}
