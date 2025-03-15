<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_year', 'length', 'description', 'rating', 'special_features', 'image', 'language_id','created_at'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_film', 'film_id', 'actor_id');
    }

    public function critics()
    {
        return $this->hasMany(Critic::class, 'film_id');
    }
}

