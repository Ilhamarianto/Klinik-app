<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <div class="mb-4 row align-items-center">
                            <div class="col">
                                <h2 class="h5 page-title">
                                    <small class="text-muted text-uppercase">Invoice</small><br />
                                    #{{ $payment->id }}
                                </h2>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-secondary" onclick="printData()">Print</button>
                                @if($payment->payment_method === 'Credit Card')
                                    {{-- <button type="button" class="btn btn-primary">Pay</button> --}}
                                      <button type="button" class="btn btn-primary" onclick="openQrisModal()">Pay</button>
                                @endif
                            </div>
                        </div>
                        <div class="shadow card">
                            <div class="p-5 card-body" id="printArea">
                                <div class="mb-5 row">
                                    <div class="mb-4 text-center col-12">
                                        <img src="./assets/images/logo.svg" class="mx-auto mb-4 navbar-brand-img brand-sm" alt="...">
                                        <h2 class="mb-0 text-uppercase">Invoice</h2>
                                        <p class="text-muted">Altavista<br /> 9022 Suspendisse Rd.</p>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="mb-2 small text-muted text-uppercase">Invoice from</p>
                                        <p class="mb-4">
                                            <strong>Imani Lara</strong><br /> Asset Management<br /> 9022 Suspendisse Rd.<br /> High Wycombe<br /> (478) 446-9234<br />
                                        </p>
                                        <p>
                                            <span class="small text-muted text-uppercase">Invoice #</span><br />
                                            <strong>{{ $payment->id }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="mb-2 small text-muted text-uppercase">Invoice to</p>
                                        <p class="mb-4">
                                            <strong>{{ $appointment->patient->name }}</strong><br /> Human Resources<br /> Ap #992-8933 Sagittis Street<br /> Ivanteyevka<br /> (803) 792-2559<br />
                                        </p>
                                        <p>
                                            <small class="small text-muted text-uppercase">Due date</small><br />
                                            <strong>{{ \Carbon\Carbon::parse($payment->payment_date)->format('F j, Y') }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <table class="table table-borderless table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" class="text-right">Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($treatments as $index => $treatment)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $treatment->treatment->name ?? 'Unknown' }}<br /> </td>
                                                <td>{{ $treatment->treatment->description}}<br /> </td>
                                                {{-- <td class="text-right">{{ $treatment->description}}</td> --}}
                                                <td class="text-right">{{ number_format($treatment->total_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-5 row">
                                    <div class="text-center col-2">
                                        <img src="./assets/images/qrcode.svg" class="mx-auto my-4 navbar-brand-img brand-sm" alt="...">
                                    </div>
                                    <div class="col-md-5">
                                        <p class="text-muted small">
                                            <strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam hendrerit nisi sed sollicitudin pellentesque. Nunc posuere purus rhoncus pulvinar aliquam.
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mr-2 text-right">
                                            <p class="mb-2 h6">
                                                <span class="text-muted">Subtotal:</span>
                                                <strong>Rp {{ number_format($payment->amount_paid, 2, ',', '.') }}</strong>
                                            </p>
                                            <p class="mb-2 h6">
                                                <span class="text-muted">Admin Fee:</span>
                                                <strong>Rp 75,000</strong>
                                            </p>
                                            <p class="mb-2 h6">
                                                <span class="text-muted">Total:</span>
                                                <strong>Rp {{ number_format($payment->amount_paid * 1.10 + 75000, 2, ',', '.') }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


             <!-- Modal for QRIS -->
                        <div class="modal fade" id="qrisModal" tabindex="-1" role="dialog" aria-labelledby="qrisModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrisModalLabel">QRIS Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="text-center modal-body">
                                        <h5>Total Amount: Rp {{ number_format($payment->amount_paid * 1.10, 2) }}</h5>
                                        <p>Scan the QR code below to complete your payment:</p>
                                        <!-- QR code image -->
                                        <img src="{{ asset('assets/assets/images/qrcode.svg')}}" class="mx-auto mb-3 img-fluid d-block" alt="QR Code">
                                        <small class="text-muted">Please use your mobile banking app to scan the QR code.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


            <!-- CSS khusus untuk cetak -->
            <style>
                @media print {
                    body {
                        font-family: Arial, sans-serif;
                        color: #333;
                        background-color: white;
                    }
                    .page-title {
                        font-size: 1.5rem;
                        margin-bottom: 20px;
                    }
                    .table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    .table th, .table td {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }
                    .table th {
                        background-color: #f2f2f2;
                    }
                    .table-striped tbody tr:nth-of-type(odd) {
                        background-color: #f9f9f9;
                    }
                    .table-borderless td, .table-borderless th {
                        border: none;
                    }
                    .text-right {
                        text-align: right;
                    }
                    .col-md-7, .col-md-5 {
                        float: left;
                        width: 50%;
                    }
                    .col-12, .text-center {
                        text-align: center;
                        margin-bottom: 30px;
                    }
                    /* Hilangkan elemen yang tidak perlu dicetak */
                    .btn, .navbar, .brand-sm, .brand-sm img {
                        display: none;
                    }
                }
            </style>

            <!-- Script untuk print -->
            <script>
                function printData() {
                    window.print();
                }

                 function openQrisModal() {
                    var myModal = new bootstrap.Modal(document.getElementById('qrisModal'));
                    myModal.show();
                }
            </script>
        </main>
    </div>
</body>
