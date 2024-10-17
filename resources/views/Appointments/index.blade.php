
<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light ">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">    <h2>Daftar Janji Temu</h2>

    <!-- Tampilkan pesan sukses atau error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Tambah Janji Temu</a>
        </div>
        <div class="card-body">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Suster</th>
                <th>Tanggal & Waktu</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->nurse ? $appointment->nurse->name : '-' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        @if($appointment->status === 'Scheduled')
                            <span class="badge badge-success">{{ $appointment->status }}</span>
                        @elseif($appointment->status === 'Cancelled')
                            <span class="badge badge-danger">{{ $appointment->status }}</span>
                        @else
                            <span class="badge badge-secondary">{{ $appointment->status }}</span>
                        @endif
                    </td>
                    <td>{{ $appointment->notes }}</td>
                    <td>
                        <!-- Tambahkan tombol aksi seperti edit, delete, dll -->
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>

    <!-- Tabel Daftar Janji Temu -->


    <!-- Tambahkan tombol untuk menambah janji temu -->
</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<script src="{{ asset('assets/nurses/js/scripts.js') }}"></script>
<x-footer>
    @push('scripts')
    <script>
    $(document).ready(function() {
        // Handle klik tombol hapus
        $('.delete-btn').on('click', function() {
            var nurseId = $(this).data('id');
            var nurseName = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete " + nurseName + ". This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, hapus data dengan AJAX
                    $.ajax({
                        url: '/nurses/' + nurseId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The nurse has been deleted.',
                                'success'
                            ).then(() => {
                                // Redirect atau reload halaman setelah hapus
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the nurse.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>

    @endpush
</x-footer>

