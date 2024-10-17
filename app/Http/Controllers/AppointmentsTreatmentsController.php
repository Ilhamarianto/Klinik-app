<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Treatments;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment_treatments;

class AppointmentsTreatmentsController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter tanggal dari query string
        $dateFilter = $request->input('date');

        // Konversi format tanggal dari dd/mm/yyyy ke Y-m-d
        if ($dateFilter) {
            $dateFilter = \DateTime::createFromFormat('d/m/Y', $dateFilter)->format('Y-m-d');
        }

        // Query dengan relasi dan filter berdasarkan tanggal
        $query = Appointment_treatments::with('appointment.patient', 'treatment');

        if ($dateFilter) {
            $query->whereHas('appointment', function ($query) use ($dateFilter) {
                $query->whereDate('appointment_date', $dateFilter);
            });
        }

        $appointmentTreatments = $query->get();

        // Agregasi data per appointment dan per tanggal
        $appointments = $appointmentTreatments->groupBy(function ($item) {
            $appointment = $item->appointment;
            $patientName = $appointment->patient->name;

            // Gunakan tanggal appointment jika ada, jika tidak ada gunakan created_at
            $date = $appointment->date ? $appointment->date->format('Y-m-d') : $item->created_at->format('Y-m-d');

            return $date . '_' . $patientName;
        })->map(function ($group, $key) {
            $totalCost = $group->sum(function ($item) {
                return $item->quantity * $item->treatment->cost;
            });

            // Gabungkan nama treatment dan quantity
            $treatments = $group->map(function ($item) {
                return $item->treatment->name . ' (' . $item->quantity . ')';
            })->implode(', ');

            return [
                'appointment' => $group->first()->appointment, // Ambil data appointment
                'patient' => $group->first()->appointment->patient, // Ambil data pasien
                'treatments' => $treatments, // Gabungkan nama treatment dan quantity
                'total_cost' => $totalCost,
                'date' => $group->first()->appointment->date ? $group->first()->appointment->date->format('Y-m-d') : $group->first()->created_at->format('Y-m-d'), // Gunakan tanggal appointment atau created_at
            ];
        });

        return view('appointment_treatments.index', compact('appointments'));
    }




    public function create()
    {
        $today = Carbon::now()->toDateString(); // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        $appointments = Appointments::whereDate('appointment_date', $today)->get(); // Mengambil appointment dengan tanggal hari ini
        $treatments = Treatments::all(); // Ambil semua treatment

        return view('appointment_treatments.create', compact('appointments', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'treatments.*.treatment_id' => 'required|exists:treatments,id',
            'treatments.*.quantity' => 'required|integer|min:1',
        ]);

        $appointmentId = $request->input('appointment_id');

        foreach ($request->input('treatments') as $treatmentData) {
            $treatment = Treatments::find($treatmentData['treatment_id']);

            // Pastikan treatment ditemukan
            if ($treatment) {
                Appointment_treatments::create([
                    'appointment_id' => $appointmentId,
                    'treatment_id' => $treatmentData['treatment_id'],
                    'quantity' => $treatmentData['quantity'],
                    'total_cost' => $treatmentData['quantity'] * $treatment->cost,
                ]);
            }
        }

        return redirect()->route('appointment_treatments.index')->with('success', 'Appointment treatments added successfully.');
    }




    public function show($appointmentId, $createdAtDate)
    {
        // Convert createdAtDate to Carbon instance
        $createdAtDate = Carbon::createFromFormat('Y-m-d', $createdAtDate)->startOfDay();

        // Find the appointment treatment that matches the appointment_id and created_at date
        $appointmentTreatment = Appointment_treatments::where('appointment_id', $appointmentId)
            ->whereDate('created_at', $createdAtDate)
            ->with(['appointment', 'treatment'])
            ->firstOrFail();

        // Pass the data to the view
        return view('appointment_treatments.show', compact('appointmentTreatment', 'createdAtDate'));
    }


    public function destroy($id, $createdAtDate)
    {
        // Pastikan format tanggal sesuai dengan format di database
        $formattedDate = date('Y-m-d', strtotime($createdAtDate));

        // Temukan dan hapus appointment_treatment
        $appointmentTreatment = Appointment_treatments::where('appointment_id', $id)
            ->whereDate('created_at', $formattedDate)
            ->firstOrFail();

        $appointmentTreatment->delete();

        return redirect()->route('appointment_treatments.index')->with('success', 'Treatment deleted successfully.');
    }

    public function edit($id, $createdAtDate)
    {
        // Ambil appointment berdasarkan ID
        $appointment = Appointments::findOrFail($id);

        // Format created_at untuk dibandingkan
        $formattedCreatedAtDate = Carbon::parse($createdAtDate)->format('Y-m-d');

        // Ambil semua appointment_treatments yang terkait dengan appointment_id dan sesuai dengan tanggal created_at
        $appointmentTreatments = Appointment_treatments::where('appointment_id', $id)
            ->whereDate('created_at', $formattedCreatedAtDate)
            ->with('treatment')
            ->get();

        // Ambil semua treatment untuk dropdown
        $treatments = Treatments::all();

        return view('appointment_treatments.edit', compact('appointment', 'appointmentTreatments', 'treatments', 'createdAtDate'));
    }










    public function update(Request $request, $id, $createdAtDate)
    {
        // Validasi input
        $request->validate([
            'treatments.*.treatment_id' => 'required|exists:treatments,id',
            'treatments.*.quantity' => 'required|integer|min:1',
            'new_treatments.*.treatment_id' => 'required|exists:treatments,id',
            'new_treatments.*.quantity' => 'required|integer|min:1',
            'delete_treatments' => 'array',
            'delete_treatments.*' => 'exists:appointment_treatments,id',
        ]);

        // Ambil appointment yang terkait
        $appointment = Appointments::findOrFail($id);

        // Format tanggal untuk dibandingkan dan digunakan dalam created_at
        $formattedCreatedAtDate = Carbon::parse($createdAtDate)->format('Y-m-d');

        // Update existing treatments
        foreach ($request->input('treatments', []) as $treatmentId => $treatmentData) {
            $appointmentTreatment = Appointment_treatments::where('appointment_id', $id)
                ->whereDate('created_at', $formattedCreatedAtDate)
                ->where('id', $treatmentId) // Filter by treatment ID
                ->first();

            if ($appointmentTreatment) {
                $appointmentTreatment->update([
                    'treatment_id' => $treatmentData['treatment_id'],
                    'quantity' => $treatmentData['quantity'],
                    'total_cost' => $treatmentData['quantity'] * Treatments::find($treatmentData['treatment_id'])->cost,
                ]);
            }
        }

        // Hapus treatments yang dipilih
        if ($request->has('delete_treatments')) {
            $deleteIds = $request->input('delete_treatments');
            Appointment_treatments::where('appointment_id', $id)
                ->whereDate('created_at', $formattedCreatedAtDate)
                ->whereIn('id', $deleteIds)
                ->delete();
        }

        // Tambah treatments baru jika ada
        if ($request->has('new_treatments') && !empty($request->input('new_treatments'))) {
            foreach ($request->input('new_treatments', []) as $treatmentData) {
                if (isset($treatmentData['treatment_id']) && isset($treatmentData['quantity'])) {
                    Appointment_treatments::create([
                        'appointment_id' => $id,
                        'treatment_id' => $treatmentData['treatment_id'],
                        'quantity' => $treatmentData['quantity'],
                        'total_cost' => $treatmentData['quantity'] * Treatments::find($treatmentData['treatment_id'])->cost,
                        'created_at' => Carbon::parse($createdAtDate), // Menetapkan created_at sesuai tanggal yang diberikan
                    ]);
                }
            }
        }

        return redirect()->route('appointment_treatments.index')->with('success', 'Appointment Treatments updated successfully.');
    }

















    public function update_multiple(Request $request)
    {
        // Validasi input
        $request->validate([
            'appointment_ids.*' => 'required|exists:appointment_treatments,id',
            'treatments.*' => 'required|exists:treatments,id',
            'quantities.*' => 'required|integer|min:1',
        ]);

        // Ambil data yang akan diupdate
        foreach ($request->input('appointment_ids') as $appointmentId) {
            $appointmentTreatment = Appointment_treatments::find($appointmentId);

            if ($appointmentTreatment) {
                $appointmentTreatment->update([
                    'treatment_id' => $request->input('treatments.' . $appointmentId),
                    'quantity' => $request->input('quantities.' . $appointmentId),
                ]);
            }
        }

        return redirect()->route('appointment_treatments.index')->with('success', 'Appointment Treatments updated successfully.');
    }
}
