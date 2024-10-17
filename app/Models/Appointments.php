<?php

namespace App\Models;

// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class Appointments extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'nurse_id',
        'appointment_date',
        'status',
        'notes',
    ];

    // Menentukan kolom tanggal di sini
    protected $dates = ['appointment_date'];


    public static function isScheduleAvailable($doctorId, $appointmentDate, $excludeId = null)
    {
        if (!($appointmentDate instanceof Carbon)) {
            $appointmentDate = Carbon::parse($appointmentDate);
        }

        $query = self::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $appointmentDate->toDateString())
            ->whereTime('appointment_date', $appointmentDate->toTimeString());

        // Abaikan janji dengan ID yang sama jika ada
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }




    public function save(array $options = [])
    {
        if (!self::isScheduleAvailable($this->doctor_id, $this->appointment_date)) {
            throw new \Exception('Dokter sudah memiliki janji pada waktu ini.');
        }

        return parent::save($options);
    }

    // Definisikan relasi
    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctor_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Nurses::class, 'nurse_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function treatments()
    {
        return $this->hasMany(Appointment_treatments::class);
    }



    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescriptions::class);
    }

    public function datatreatment()
    {
        return $this->belongsToMany(Treatments::class, 'appointment_requirtment')
            ->withPivot('quantity', 'total_cost')
            ->withTimestamps();
    }

    // app/Models/Appointments.php
    public function dataappointments()
    {
        return $this->hasMany(Appointment_treatments::class, 'appointment_id');
    }
}
