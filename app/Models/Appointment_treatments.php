<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment_treatments extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'treatment_id',
        'quantity',
        'total_cost',
    ];
    // Laravel otomatis mengonversi kolom DATETIME ke Carbon
    protected $dates = ['appointment_date'];

    // Menggunakan accessor untuk format khusus
    public function getFormattedDateAttribute()
    {
        // Debugging: cek tipe data appointment_date
        dd($this->appointment_date, get_class($this->appointment_date));

        return $this->appointment_date ? $this->appointment_date->format('Y-m-d') : 'Unknown Date';
    }

    public function appointment()
    {
        return $this->belongsTo(Appointments::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatments::class);
    }
}
