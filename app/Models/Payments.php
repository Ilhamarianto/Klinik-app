<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;



    protected $fillable = [
        'appointment_id',
        'treatment_id',
        'amount_paid',
        'payment_date',
        'payment_method',
    ];

    public $timestamps = true; // Pastikan timestamps aktif


    public function appointment()
    {
        return $this->belongsTo(Appointments::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatments::class);
    }

    // Accessor to generate ID based on current date
    public function getFormattedIdAttribute()
    {
        return now()->format('Ymd') . '-' . $this->id;
    }

    public static function calculateAmountPaid($appointmentId)
    {
        $totalCost = Appointment_treatments::where('appointment_id', $appointmentId)
            ->sum('total_cost');

        // Tambahkan biaya admin 75 ribu
        return $totalCost + 75000;
    }

    // Relasi ke tabel Patients
    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }

    // Relasi ke tabel Doctors
    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }

    // Relasi ke tabel Nurses
    public function nurse()
    {
        return $this->belongsTo(Nurses::class);
    }
}
