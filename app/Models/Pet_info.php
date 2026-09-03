<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet_info extends Model
{
    protected $fillable = [
        'ownerId',
        'name',
        'Personality',
        'gender',
        'whight',
        'type',
        'status',
        'categore',
        'description',
        'age',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
