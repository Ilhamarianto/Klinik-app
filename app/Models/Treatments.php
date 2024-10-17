<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment_treatments::class);
    }
    public function treatment()
    {
        return $this->belongsTo(Treatments::class, 'treatment_id');
    }
    public function payments()
    {
        return $this->hasMany(Payments::class);
    }
    public function dataappointments()
    {
        return $this->belongsToMany(Appointments::class, 'appointment_requirtment')
            ->withPivot('quantity', 'total_cost')
            ->withTimestamps();
    }
}
