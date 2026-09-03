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

    public function info()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}