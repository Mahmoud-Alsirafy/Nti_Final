<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal_data extends Model
{
    protected $fillable = [
        'userId',
        'clinicName',
        'clinicAddress',
        'clinicNumber',
        'address',
        'city',
        'state',
        'country',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function info()
    {
        return $this->user();
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}