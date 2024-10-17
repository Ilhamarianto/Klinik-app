<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $table = "patients";
    protected $fillable = [
        'name',
        'date_of_birth',
        'email',
        'phone_number',
        'address',
        'gender',

    ];

    public $timestamps = true; // Pastikan timestamps aktif
}
