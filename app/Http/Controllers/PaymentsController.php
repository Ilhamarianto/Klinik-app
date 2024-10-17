<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment_treatments;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payments::with('appointment')->get();
        return view('payments.index', compact('payments'));
    }

    // Show form for creating a new payment
    public function create()
    {
        // Logic to display payment creation form
        // $appointments = Appointments::all(); // Get all appointments for dropdown
        // $appointments = Appointments::whereDate('created_at', now()->format('Y-m-d'))->get();
        // $appointments = Appointments::whereDate('created_at', now()->toDateString())->get();
        $appointments = Appointments::select('appointments.*') // Pastikan hanya memilih kolom dari appointments
            ->join('appointment_treatments', 'appointments.id', '=', 'appointment_treatments.appointment_id')
            ->whereDate('appointment_treatments.created_at', now()->toDateString())
            ->distinct() // Menghilangkan duplikat jika ada
            ->get();

        return view('payments.create', compact('appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'payment_date' => 'required|date',
        ]);

        // Hitung amount_paid
        $amountPaid = Payments::calculateAmountPaid($request->appointment_id);

        Payments::create([
            'appointment_id' => $request->appointment_id,
            'amount_paid' => $amountPaid,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method ?? 'Cash', // Atur default jika payment_method tidak disertakan
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function getTotalCost($id)
    {
        $totalCost = Appointment_treatments::where('appointment_id', $id)
            ->sum('total_cost');

        // Tambahkan biaya admin
        $amountPaid = $totalCost + 75000;

        return response()->json(['amount_paid' => $amountPaid]);
    }




    public function show($id)
    {
        // Ambil data pembayaran berdasarkan ID
        $payment = Payments::findOrFail($id);

        // Ambil appointment berdasarkan ID pembayaran
        $appointment = Appointments::findOrFail($payment->appointment_id);

        // Ambil semua treatment yang terkait dengan appointment berdasarkan appointment_id
        $treatments = Appointment_treatments::where('appointment_id', $appointment->id)
            ->with('treatment') // Eager load the related treatment
            ->get();

        // Debug: periksa data treatments
        Log::info('Treatments: ' . $treatments);

        return view('payments.show', compact('payment', 'appointment', 'treatments'));
    }





    // Show form for editing a payment
    public function edit($id)
    {
        $payment = Payments::findOrFail($id);
        $appointments = Appointments::all();
        return view('payments.edit', compact('payment', 'appointments'));
    }

    // Update payment in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $payment = Payments::findOrFail($id);
        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    // Delete a payment
    public function destroy($id)
    {
        $payment = Payments::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
