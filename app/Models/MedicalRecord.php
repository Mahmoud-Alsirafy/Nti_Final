<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'doctor_id',
        'title',
        'type',
        'visit_date',
        'weight',
        'diagnosis',
        'treatment_plan',
        'internal_notes',
        'report_file',
        'attachment_name',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet_info::class, 'pet_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
