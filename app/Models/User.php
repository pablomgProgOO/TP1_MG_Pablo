<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['login', 'password', 'email', 'last_name', 'first_name'];

    public function critics()
    {
        return $this->hasMany(Critic::class, 'user_id');
    }
}

