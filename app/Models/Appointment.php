<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'start_datetime',
        'end_datetime',
        'duration_minutes', // Add this line
        'mode',
        'meet_link',
        'status',
    ];

    protected $dates = ['start_datetime', 'end_datetime'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}