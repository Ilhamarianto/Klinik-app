<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - {{ $date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #2C3E50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #2980B9;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        tfoot td {
            font-weight: bold;
            font-size: 16px;
            background-color: #ECF0F1;
        }
        .total-row {
            background-color: #27AE60;
            color: white;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Laporan Harian Pembayaran</h1>
    <h2>Tanggal: {{ $date }}</h2>

    <table>
        <thead>
            <tr>
                <th>ID Pembayaran</th>
                <th>ID Janji Temu</th>
                <th>ID Perawatan</th>
                <th>Jumlah Dibayar</th>
                <th>Tanggal Pembayaran</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->appointment_id }}</td>
                    <td>{{ $payment->treatment_id }}</td>
                    <td>Rp. {{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->payment_method }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total Keseluruhan</td>
                <td colspan="3" class="text-center">Rp. {{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
