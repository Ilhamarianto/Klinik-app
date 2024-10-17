<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="container">
                            <h2>Edit Janji Temu</h2>

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

                            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="patient_id">Pasien</label>
        <select name="patient_id" id="patient_id" class="form-control" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                    {{ $patient->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="doctor_id">Dokter</label>
        <select name="doctor_id" id="doctor_id" class="form-control" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="nurse_id">Suster</label>
        <select name="nurse_id" id="nurse_id" class="form-control">
            @foreach($nurses as $nurse)
                <option value="{{ $nurse->id }}" {{ old('nurse_id', $appointment->nurse_id) == $nurse->id ? 'selected' : '' }}>
                    {{ $nurse->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="appointment_date">Tanggal & Waktu</label>
        <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control"
               value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <input type="text" name="status" id="status" class="form-control" required value="{{ old('status', $appointment->status) }}">
    </div>

    <div class="form-group">
        <label for="notes">Catatan</label>
        <textarea name="notes" id="notes" class="form-control">{{ old('notes', $appointment->notes) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Perbarui</button>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<x-footer></x-footer>
