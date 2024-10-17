<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                      <h1 class="mb-4">Daftar Janji Temu</h1>
    <h1 class="mb-4">Daftar Appointment Treatments</h1>

    {{-- Pesan sukses atau error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Appointment Treatments --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Perawatan</th>
                <th>Total Biaya</th>
                <th>Tanggal Appointment</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $key => $appointment)
                <tr>
                    {{-- <td>{{ $key + 1 }}</td> --}}
                    <td>{{ $appointment['patient']->name }}</td>
                    <td>{{ $appointment['appointment']->doctor->name }}</td>
                    <td>{{ $appointment['treatments'] }}</td>
                    <td>Rp {{ number_format($appointment['total_cost'], 0, ',', '.') }}</td>
                    <td>{{ $appointment['date'] }}</td>
                    <td>
                        {{-- <a href="{{ route('appointment_treatments.show', ['appointmentId' => $appointment->id, 'createdAtDate' => $treatment->created_at->format('Y-m-d')]) }}" class="btn btn-primary btn-sm">View Details</a> --}}

                   {{-- <a href="{{ route('appointment_treatments.edit', ['id' => $appointment['appointment']->id, 'createdAtDate' => $appointment['date']]) }}" class="btn btn-primary btn-sm">Edit</a> --}}
@php
    // Mendapatkan tanggal hari ini
    $today = \Carbon\Carbon::now()->format('Y-m-d');
@endphp

@if ($appointment['date'] === $today)
    <a href="{{ route('appointment_treatments.edit', ['id' => $appointment['appointment']->id, 'createdAtDate' => $appointment['date']]) }}" class="btn btn-primary btn-sm">Edit</a>
@else
    <!-- Hidden or disabled button, or you can choose not to render anything -->
    <span class="btn btn-secondary btn-sm">Edit</span> <!-- or simply remove this line -->
@endif
<form action="{{ route('appointment_treatments.destroy', ['id' => $appointment['appointment']->id, 'createdAtDate' => $appointment['date']]) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
</form>







                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tombol Tambah Appointment Treatments --}}
    <a href="{{ route('appointment_treatments.create') }}" class="btn btn-primary">Tambah Appointment Treatment</a>
</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('date');
    const table = document.querySelector('.table');
    const rows = table.querySelectorAll('tbody tr');

    dateInput.addEventListener('change', () => {
        const selectedDate = dateInput.value;

        rows.forEach(row => {
            const dateCell = row.children[5]; // Mengambil elemen tanggal di kolom keenam (indeks 5)
            const rowDate = dateCell.textContent.trim();

            if (selectedDate && selectedDate !== rowDate) {
                row.style.display = 'none';
            } else {
                row.style.display = '';
            }
        });
    });
});
</script>

