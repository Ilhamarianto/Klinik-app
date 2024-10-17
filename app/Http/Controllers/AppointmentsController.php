<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Nurses;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\Appointment;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    public function index()
    {
        $appointments = Appointments::latest()->paginate(5);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        // $patients = User::where('role', 'patient')->get();
        // $doctors = User::where('role', 'doctor')->get();
        // $nurses = User::where('role', 'nurse')->get();
        $patients = Patients::all();
        $doctors = Doctors::all();
        $nurses = Nurses::all();
        return view('appointments.create', compact('patients', 'doctors', 'nurses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'nurse_id' => 'nullable|exists:nurses,id',
            'appointment_date' => 'required|date_format:Y-m-d\TH:i',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $appointmentDate = $request->input('appointment_date');
        $doctorId = $request->input('doctor_id');

        if (!Appointments::isScheduleAvailable($doctorId, $appointmentDate)) {
            return redirect()->back()->withErrors(['appointment_date' => 'Dokter sudah memiliki janji pada waktu ini.']);
        }

        Appointments::create($request->all());
        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dibuat.');
    }

    public function edit(Appointments $appointment)
    {
        $patients = Patients::all();
        $doctors = Doctors::all();
        $nurses = Nurses::all();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'nurses'));
    }

    public function update(Request $request, Appointments $appointment)
    {
        // Validasi input dari form
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'nurse_id' => 'nullable|exists:nurses,id',
            'appointment_date' => 'required|date_format:Y-m-d\TH:i',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Ubah appointment_date menjadi objek Carbon
        $appointmentDate = Carbon::parse($request->input('appointment_date'));

        // Ubah appointment_date dari model menjadi objek Carbon
        $existingAppointmentDate = Carbon::parse($appointment->appointment_date);

        // Pengecekan apakah dokter atau waktu janji berubah
        $isDoctorChanged = $appointment->doctor_id != $request->doctor_id;
        $isDateChanged = !$existingAppointmentDate->isSameMinute($appointmentDate); // Gunakan isSameMinute untuk membandingkan tanggal dan waktu

        if ($isDoctorChanged || $isDateChanged) {
            // Validasi ketersediaan jadwal dokter dengan pengecualian janji saat ini
            if (!Appointments::isScheduleAvailable($request->doctor_id, $appointmentDate, $appointment->id)) {
                return redirect()->back()->withErrors(['appointment_date' => 'Dokter sudah memiliki janji pada waktu ini.']);
            }
        }

        // Update data janji temu
        $appointment->update([
            'patient_id' => $request->input('patient_id'),
            'doctor_id' => $request->input('doctor_id'),
            'nurse_id' => $request->input('nurse_id'),
            'appointment_date' => $appointmentDate,
            'status' => $request->input('status'),
            'notes' => $request->input('notes'),
        ]);

        // Redirect setelah berhasil update
        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil diperbarui.');
    }





    public function destroy(Appointments $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Janji temu berhasil dihapus.');
    }
}
