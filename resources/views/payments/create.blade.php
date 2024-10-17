<>
    <x-header></x-header>
    <x-navbar></x-navbar>
    <body class="vertical light">
        <div class="wrapper">
            <main role="main" class="main-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h1 class="page-title">Add Payments</h1>

                            <div class="card">
                                <div class="card-body">
                             @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="appointment_id">Appointment</label>
            <select name="appointment_id" id="appointment_id" class="form-control" required>
                <option value="">Select Appointment</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}">
    {{ $appointment->patient->name }} - {{ $appointment->appointment_date}}
</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount (Calculated Automatically)</label>
            <input type="text" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" readonly>
        </div>

        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="" class="form-control"> -- Pilih Pembayaran -- </option>
                <option value="Cash" id="payment_method" name='payment_method' class="form-control"> Cash </option>
                <option value="Credit Card" id="payment_method" name='payment_method' class="form-control"> Credit Card </option>
                <option value="Insurance" id="payment_method" name='payment_method' class="form-control"> Insurance </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

            <script>
        document.getElementById('appointment_id').addEventListener('change', function() {
            var appointmentId = this.value;
            var amountInput = document.getElementById('amount');

            if (appointmentId) {
                fetch(`/appointment/${appointmentId}/total-cost`)
                    .then(response => response.json())
                    .then(data => {
                        amountInput.value = data.amount_paid;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                amountInput.value = '';
            }
        });
            </script>
    </body>
