<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patients;
use App\Models\Payments;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month; // Ambil bulan saat ini

        // Ambil jumlah pasien per bulan untuk tahun ini
        $monthlyPatientCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyPatientCounts[$month] = Patients::whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->count();
        }

        // Data untuk tampilan
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [
            'labels' => $months,
            'data' => array_values($monthlyPatientCounts)
        ];

        // Menghitung jumlah pasien bulan ini
        $patientCountThisMonth = Patients::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Menghitung jumlah pasien bulan lalu
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        $patientCountLastMonth = Patients::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->count();

        // Hitung persentase perubahan
        if ($patientCountLastMonth > 0) {
            $percentageChange = (($patientCountThisMonth - $patientCountLastMonth) / $patientCountLastMonth) * 100;
        } else {
            $percentageChange = 100; // Jika tidak ada pasien bulan lalu
        }

        // Ambil total pembayaran per bulan untuk tahun ini
        $monthlyPayments = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyPayments[$month] = Payments::whereMonth('payment_date', $month)
                ->whereYear('payment_date', $currentYear)
                ->sum('amount_paid');
        }

        // Kirim data ke view
        $data['payments'] = array_values($monthlyPayments);

        return view('dashboard', compact('patientCountThisMonth', 'percentageChange', 'data', 'currentMonth'));
    }
}
