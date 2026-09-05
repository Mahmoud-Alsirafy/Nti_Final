<?php

namespace App\Models;


use App\Models\Personal_data;
use App\Models\Pet_info;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
        'qr_code',

    ];

    protected $hidden = [
        'password',
        'remember_token',

    ];

    protected $visible = [
        'id',
        'name',
        'email',

    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personalData()
    {
        return $this->hasOne(Personal_data::class, 'userId');
    }

    public function pits()
    {
        return $this->hasMany(Pet_info::class, 'ownerId');
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
