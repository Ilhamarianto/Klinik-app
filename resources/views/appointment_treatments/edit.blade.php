<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2>Edit Appointment Treatments</h2>

                        <!-- Tampilkan informasi pasien dan dokter -->
                        <div class="card mb-4">
                            <div class="card-header">Detail Appointment</div>
                            <div class="card-body">
                                <p><strong>Nama Pasien:</strong> {{ $appointment->patient->name }}</p>
                                <p><strong>Nama Dokter:</strong> {{ $appointment->doctor->name }}</p>
                                <p><strong>Tanggal Created At:</strong> {{ $createdAtDate }}</p>
                                <p><strong>Total Biaya:</strong> Rp {{ number_format($appointmentTreatments->sum(fn($t) => $t->quantity * $t->treatment->cost), 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Form untuk mengedit treatment -->
                        <form action="{{ route('appointment_treatments.update', ['id' => $appointment->id, 'createdAtDate' => $createdAtDate]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Tanggal Created At -->
                            <input type="hidden" name="created_at" value="{{ $createdAtDate }}">

                            <!-- Tampilkan setiap treatment yang sudah ada -->
                            <h4>Existing Treatments</h4>
                            @foreach ($appointmentTreatments as $key => $appointmentTreatment)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="treatment-{{ $key }}">Treatment</label>
                                    <select name="treatments[{{ $appointmentTreatment->id }}][treatment_id]" id="treatment-{{ $key }}" class="form-control">
                                        @foreach ($treatments as $treatment)
                                        <option value="{{ $treatment->id }}" {{ $appointmentTreatment->treatment_id == $treatment->id ? 'selected' : '' }}>
                                            {{ $treatment->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="quantity-{{ $key }}">Quantity</label>
                                    <input type="number" name="treatments[{{ $appointmentTreatment->id }}][quantity]" value="{{ $appointmentTreatment->quantity }}" id="quantity-{{ $key }}" class="form-control" min="1">
                                </div>
                                <div class="col-md-2">
                                    <!-- Input hidden untuk menghapus -->
                                    <input type="checkbox" name="delete_treatments[]" value="{{ $appointmentTreatment->id }}" id="delete-treatment-{{ $key }}">
                                    <label for="delete-treatment-{{ $key }}" class="form-check-label">Delete</label>
                                </div>
                            </div>
                            @endforeach

                            <!-- Form untuk menambahkan treatment baru -->
                            <h4>Add New Treatments</h4>
                            <div id="new-treatments">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="new-treatment-0">Treatment</label>
                                        <select name="new_treatments[0][treatment_id]" id="new-treatment-0" class="form-control">
                                            @foreach ($treatments as $treatment)
                                            <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="new-quantity-0">Quantity</label>
                                        <input type="number" name="new_treatments[0][quantity]" id="new-quantity-0" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>

                            <!-- Button untuk menambahkan baris treatment baru -->
                            <button type="button" id="add-treatment" class="btn btn-secondary mb-3">Add Another Treatment</button>

                            <!-- Tombol Submit -->
                            <button type="submit" class="btn btn-primary">Update Treatments</button>
                        </form>

                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

@section('scripts')
<script>
    let treatmentCount = {{ count($appointmentTreatments) }};

    document.getElementById('add-treatment').addEventListener('click', function() {
        const newTreatmentDiv = document.createElement('div');
        newTreatmentDiv.classList.add('row', 'mb-3');

        newTreatmentDiv.innerHTML = `
            <div class="col-md-4">
                <label for="new-treatment-${treatmentCount}">Treatment</label>
                <select name="new_treatments[${treatmentCount}][treatment_id]" id="new-treatment-${treatmentCount}" class="form-control">
                    @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="new-quantity-${treatmentCount}">Quantity</label>
                <input type="number" name="new_treatments[${treatmentCount}][quantity]" id="new-quantity-${treatmentCount}" class="form-control" min="1">
            </div>
        `;

        document.getElementById('new-treatments').appendChild(newTreatmentDiv);
        treatmentCount++;
    });
</script>
@endsection
