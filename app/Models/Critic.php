<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critic extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'score', 'film_id', 'user_id','created_at', 'updated_at'];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

