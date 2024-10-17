<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2>Appointment Treatments Details</h2>

                        <!-- Tampilkan informasi pasien dan dokter -->
                        <div class="card mb-4">
                            <div class="card-header">Detail Appointment</div>
                            <div class="card-body">
                                <p><strong>Nama Pasien:</strong> {{ $appointmentTreatment->appointment->patient->name }}</p>
                                <p><strong>Nama Dokter:</strong> {{ $appointmentTreatment->appointment->doctor->name }}</p>
                                <p><strong>Tanggal Created At:</strong> {{ \Carbon\Carbon::parse($createdAtDate)->format('Y-m-d') }}</p>
                                <p><strong>Total Biaya:</strong> Rp {{ number_format($appointmentTreatment->quantity * $appointmentTreatment->treatment->cost, 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Tampilkan detail treatment -->
                        <div class="card mb-4">
                            <div class="card-header">Treatment Details</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Treatment Name</th>
                                            <th>Quantity</th>
                                            <th>Cost</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $appointmentTreatment->treatment->name }}</td>
                                            <td>{{ $appointmentTreatment->quantity }}</td>
                                            <td>Rp {{ number_format($appointmentTreatment->treatment->cost, 2, ',', '.') }}</td>
                                            <td>Rp {{ number_format($appointmentTreatment->quantity * $appointmentTreatment->treatment->cost, 2, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
