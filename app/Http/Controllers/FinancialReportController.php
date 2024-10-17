<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Excel;
use App\Exports\PaymentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Payment; // Pastikan model ini sudah ada

class FinancialReportController extends Controller
{
    public function dailyReport(Request $request)
    {
        // Ambil tanggal dari request, jika tidak ada gunakan tanggal saat ini
        $date = $request->input('date', date('Y-m-d'));

        // Query dengan relasi ke pasien, dokter, dan perawat
        $payments = Payments::whereDate('payment_date', $date)
            ->with(['appointment.patient', 'appointment.doctor', 'appointment.nurse']) // Eager load relasi
            ->get();

        // Hitung total dari pembayaran yang ada
        $totalAmount = $payments->sum('amount_paid');

        // Kembalikan view dengan data yang diperlukan
        return view('reports.daily', compact('payments', 'totalAmount', 'date'));
    }

    public function downloadCsv(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $payments = Payments::whereDate('payment_date', $date)->get();
        return Excel::download(new PaymentsExport($payments), 'daily_report_' . $date . '.csv');
    }

    public function downloadPdf(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $payments = Payments::whereDate('payment_date', $date)->get();
        $totalAmount = $payments->sum('amount_paid');

        $pdf = Pdf::loadView('reports.daily_pdf', compact('payments', 'totalAmount', 'date'));
        return $pdf->download('daily_report_' . $date . '.pdf');
    }


    // mothly
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $payments = Payments::whereYear('payment_date', date('Y', strtotime($month)))
            ->whereMonth('payment_date', date('m', strtotime($month)))
            ->get();
        $totalAmount = $payments->sum('amount_paid');
        return view('reports.monthly', compact('payments', 'totalAmount', 'month'));
    }

    public function downloadMonthlyCsv(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $payments = Payments::whereYear('payment_date', date('Y', strtotime($month)))
            ->whereMonth('payment_date', date('m', strtotime($month)))
            ->get();
        return Excel::download(new PaymentsExport($payments), 'monthly_report_' . $month . '.csv');
    }

    public function downloadMonthlyPdf(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $payments = Payments::whereYear('payment_date', date('Y', strtotime($month)))
            ->whereMonth('payment_date', date('m', strtotime($month)))
            ->get();
        $totalAmount = $payments->sum('amount_paid');
        $pdf = Pdf::loadView('reports.monthly_pdf', compact('payments', 'totalAmount', 'month'));
        return $pdf->download('monthly_report_' . $month . '.pdf');
    }
}
