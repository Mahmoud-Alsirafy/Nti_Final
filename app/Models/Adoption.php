<?php

namespace App\Models;

use App\Models\Pet_info;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    protected $fillable = [
        'pet_id',
        'status',
        'adopter_id',
        'why',
    ];


    public function pet()
    {
        return $this->belongsTo(Pet_info::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function adopter()
    {
        return $this->belongsTo(User::class, 'adopter_id');
    }
}
