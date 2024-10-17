<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="container">
                            <h2>Tambah Janji Temu</h2>

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf


                               <div class="mb-3 form-group">
                                <label for="patient_id">Pasien</label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" class="form-control">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                <small id="no-data-message-patient" class="text-danger" style="display:none;">Data tidak ditemukan!</small>
                            </div>

<div class="mb-3 form-group">
    <label for="doctor_id">Dokter</label>
    <select name="doctor_id" id="doctor_id" class="form-control" required>
        <option value="">-- Pilih Dokter --</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
        @endforeach
    </select>
    <small id="no-data-message-doctor" class="text-danger" style="display:none;">Data tidak ditemukan!</small>
</div>

<div class="mb-3 form-group">
    <label for="nurse_id">Suster</label>
    <select name="nurse_id" id="nurse_id" class="form-control">
        <option value="">-- Pilih Suster --</option>
        @foreach($nurses as $nurse)
            <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
        @endforeach
    </select>
    <small id="no-data-message-nurse" class="text-danger" style="display:none;">Data tidak ditemukan!</small>
</div>


                                <div class="form-group">
                                    <label for="appointment_date">Tanggal & Waktu</label>
                                    <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" required>

                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" name="status" id="status" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="notes">Catatan</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<x-footer>
    @push('scripts')
    <script>
        $(document).ready(function() {
    // Inisialisasi Select2 untuk setiap dropdown
    $('#patient_id').select2({
        placeholder: "Cari Pasien atau masukkan nama",
        allowClear: true
    }).on('select2:close', function () {
        checkForNoData('patient_id', 'no-data-message-patient');
    });

    $('#doctor_id').select2({
        placeholder: "Cari Dokter atau masukkan nama",
        allowClear: true
    }).on('select2:close', function () {
        checkForNoData('doctor_id', 'no-data-message-doctor');
    });

    $('#nurse_id').select2({
        placeholder: "Cari Suster atau masukkan nama",
        allowClear: true
    }).on('select2:close', function () {
        checkForNoData('nurse_id', 'no-data-message-nurse');
    });

    // Fungsi untuk cek apakah data ada atau tidak setelah pencarian
    function checkForNoData(selectId, messageId) {
        var inputValue = $('.select2-search__field').val(); // Ambil nilai input search
        var selectValue = $('#' + selectId).val(); // Ambil nilai terpilih
        if (inputValue && !selectValue) {
            $('#' + messageId).show(); // Tampilkan pesan jika tidak ada data yang cocok
        } else {
            $('#' + messageId).hide(); // Sembunyikan pesan jika ada data yang cocok
        }
    }
});

    </script>
    @endpush
</x-footer>
