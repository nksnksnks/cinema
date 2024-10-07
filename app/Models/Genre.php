<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'ci_genre';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
    public $timestamps = true;

    public function movie()
    {
        return $this->hasMany('App\Models\Movie', 'genre_id', 'id');
    }
}
