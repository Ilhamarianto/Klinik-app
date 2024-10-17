<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title text-center my-4">Laporan Bulanan</h1>

                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <span><strong>Bulan:</strong> {{ $month }}</span>
                                <form method="GET" action="{{ route('reports.monthly') }}" class="form-inline">
                                    <div class="form-group mb-0 mr-2">
                                        <input type="month" name="month" class="form-control" value="{{ $month ?? date('Y-m') }}">
                                    </div>
                                    <button type="submit" class="btn btn-light">Cari</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <a href="{{ route('reports.monthly.csv', ['month' => $month]) }}" class="btn btn-success mr-2">Unduh CSV</a>
                                        <a href="{{ route('reports.monthly.pdf', ['month' => $month]) }}" class="btn btn-danger">Unduh PDF</a>
                                    </div>
                                    <button onclick="window.print()" class="btn btn-secondary">Print</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr class="text-center">
                                                <th>ID Pembayaran</th>
                                                <th>Nama Pasien</th>
                                                <th>Nama Dokter</th>
                                                <th>Nama Perawat</th>
                                                <th>Jumlah Dibayar</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Metode Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                                <tr>
                                                    <td class="text-center">{{ $payment->id }}</td>
                                                    <td class="text-center">{{ $payment->appointment->patient->name ?? 'Tidak Ada' }}</td>
                                                    <td class="text-center">{{ $payment->appointment->doctor->name ?? 'Tidak Ada' }}</td>
                                                    <td class="text-center">{{ $payment->appointment->nurse->name ?? 'Tidak Ada' }}</td>
                                                    <td class="text-right">Rp. {{ number_format($payment->amount_paid, 2) }}</td>
                                                    <td class="text-center">{{ $payment->payment_date }}</td>
                                                    <td class="text-center">{{ $payment->payment_method }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right font-weight-bold">Total: </td>
                                                <td colspan="3" class="text-right"><strong>Rp.{{ number_format($totalAmount, 2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.col-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </main>
    </div>
<x-footer></x-footer>
</body>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .card {
        border-radius: 12px;
    }
    .btn {
        border-radius: 5px;
    }
    .table th {
        background-color: #343a40;
        color: white;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    @media print {
        .card-header, .d-flex, .btn {
            display: none !important;
        }
    }
</style>
