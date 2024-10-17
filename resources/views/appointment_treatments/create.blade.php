<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                       <h1 class="mb-4">Tambah Treatments ke Appointment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointment_treatments.store') }}" method="POST">
        @csrf

        {{-- <div class="mb-3 form-group">
            <label for="appointment_id">Pilih Appointment</label>
            <select name="appointment_id" class="form-control">
                @foreach ($appointments as $appointment)
                    <option value="{{ $appointment->id }}">Appointment #{{ $appointment->id }} - {{ $appointment->patient->name }} on {{ $appointment->appointment_date }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="mb-3 form-group">
    <label for="appointment_id">Pilih Appointment</label>
    <select id="appointment_id" name="appointment_id" class="form-control">
        <option value="">-- Pilih Appointment --</option>
        @foreach ($appointments as $appointment)
            <option value="{{ $appointment->id }}">
                Appointment #{{ $appointment->id }} - {{ $appointment->patient->name }} on {{ $appointment->appointment_date }}
            </option>
        @endforeach
    </select>
    <small id="no-data-message" class="text-danger" style="display:none;">Data tidak ditemukan!</small>
</div>


        <div id="treatments-container">
            <div class="mb-3 form-group">
                <label for="treatments[0][treatment_id]">Treatment</label>
                <select name="treatments[0][treatment_id]" class="form-control">
                    @foreach ($treatments as $treatment)
                        <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                    @endforeach
                </select>

                <label for="treatments[0][quantity]">Quantity</label>
                <input type="number" name="treatments[0][quantity]" class="form-control" min="1" required>
            </div>
        </div>

        <button type="button" id="add-treatment" class="mb-3 btn btn-secondary">Tambah Treatment</button>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
document.getElementById('add-treatment').addEventListener('click', function() {
    let container = document.getElementById('treatments-container');
    let index = container.children.length;
    let newTreatment = `
        <div class="mb-3 form-group">
            <label for="treatments[${index}][treatment_id]">Treatment</label>
            <select name="treatments[${index}][treatment_id]" class="form-control">
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </select>
            <label for="treatments[${index}][quantity]">Quantity</label>
            <input type="number" name="treatments[${index}][quantity]" class="form-control" min="1" required>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newTreatment);
});

$(document).ready(function() {
    $('#appointment_id').select2({
        placeholder: "Cari Appointment atau masukkan nama",
        allowClear: true
    });

    // Handle event ketika pencarian tidak menemukan hasil
    $('#appointment_id').on('select2:close', function (e) {
        var inputValue = $('.select2-search__field').val(); // nilai input search
        if (inputValue && !$(this).val()) {
            $('#no-data-message').show(); // tampilkan pesan jika tidak ada data
        } else {
            $('#no-data-message').hide(); // sembunyikan pesan jika ada data yang cocok
        }
    });
});

</script>

