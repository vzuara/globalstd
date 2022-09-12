<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Turn;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'published_at', 'status', 'image'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['published_at' => 'datetime:Y-m-d', 'status' => 'boolean'];

    public function turns()
    {
        return $this->belongsToMany(Turn::class, 'movie_turn');
    }
}
