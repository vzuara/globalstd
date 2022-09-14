<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Movie;

class Turn extends Model
{
    use HasFactory;

    protected $fillable = ['turn', 'status'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['turn' => 'datetime:H:i', 'status' => 'boolean'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_turn')->withPivot('itinerary');
    }
}
