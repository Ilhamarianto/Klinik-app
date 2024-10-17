<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="mb-2 row align-items-center">
                            <div class="col">
                                <h2 class="h5 page-title">Welcome!</h2>
                            </div>
                            <div class="col-auto">
                                <form class="form-inline">
                                    <div class="form-group d-none d-lg-inline">
                                        <label for="reportrange" class="sr-only">Date Ranges</label>
                                        <div id="reportrange" class="px-2 py-2 text-muted">
                                            <span class="small"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm">
                                            <span class="fe fe-refresh-ccw fe-16 text-muted"></span>
                                        </button>
                                        <button type="button" class="mr-2 btn btn-sm">
                                            <span class="fe fe-filter fe-16 text-muted"></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- widgets -->
                        <div class="my-4 row">
                            <div class="col-md-4">
                                <div class="mb-4 shadow card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <small class="mb-1 text-muted">Jumlah Pasien Bulan Ini</small>
                                                <h3 class="mb-0 card-title">{{ $patientCountThisMonth }}</h3>
                                                <p class="mb-0 small text-muted">
                                                    @if($percentageChange > 0)
                                                        <span class="fe fe-arrow-up fe-12 text-success"></span><span>+{{ number_format($percentageChange, 1) }}% dari bulan lalu</span>
                                                    @elseif($percentageChange < 0)
                                                        <span class="fe fe-arrow-down fe-12 text-danger"></span><span>{{ number_format($percentageChange, 1) }}% dari bulan lalu</span>
                                                    @else
                                                        <span class="fe fe-minus fe-12 text-muted"></span><span> Tidak ada perubahan dari bulan lalu</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right col-4">
                                                <span class="sparkline inlineline"></span>
                                            </div>
                                        </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                                <div class="mb-4 shadow card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                           <div class="col">
                                            <div class="col">
    <small class="mb-1 text-muted">Total Pembayaran Bulan Ini</small>
    <h3 class="mb-0 card-title">{{ number_format($data['payments'][$currentMonth - 1], 2) }}</h3>
    <p class="mb-0 small text-muted">
        @php
            $paymentLastMonth = $data['payments'][$currentMonth - 2] ?? 0; // Jika bulan lalu tidak ada data, set 0
            $paymentThisMonth = $data['payments'][$currentMonth - 1];
            if ($paymentLastMonth > 0) {
                $paymentPercentageChange = (($paymentThisMonth - $paymentLastMonth) / $paymentLastMonth) * 100;
            } else {
                $paymentPercentageChange = 100; // Jika bulan lalu tidak ada pembayaran
            }
        @endphp

        @if($paymentPercentageChange > 0)
            <span class="fe fe-arrow-up fe-12 text-success"></span>
            <span>+{{ number_format($paymentPercentageChange, 1) }}% dari bulan lalu</span>
        @elseif($paymentPercentageChange < 0)
            <span class="fe fe-arrow-down fe-12 text-danger"></span>
            <span>{{ number_format($paymentPercentageChange, 1) }}% dari bulan lalu</span>
        @else
            <span class="fe fe-minus fe-12 text-muted"></span>
            <span>Tidak ada perubahan dari bulan lalu</span>
        @endif
    </p>
</div>

                                           </div>
                                            <div class="text-right col-4">
                                                <span class="sparkline inlinepie"></span>
                                            </div>
                                        </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                                <div class="mb-4 shadow card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <small class="mb-1 text-muted">Visitors</small>
                                                <h3 class="mb-0 card-title">108</h3>
                                                <p class="mb-0 small text-muted">
                                                    <span class="fe fe-arrow-up fe-12 text-success"></span><span>37.7% Last week</span>
                                                </p>
                                            </div>
                                            <div class="text-right col-4">
                                                <span class="sparkline inlinebar"></span>
                                            </div>
                                        </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="mb-4 col-md-6">
                                <div class="shadow card">
                                    <div class="card-header">
                                        <strong class="mb-0 card-title">Line Chart</strong>
                                        <span class="float-right mr-2 badge badge-light">30 days</span>
                                        <span class="float-right mr-2 badge badge-light">7 days</span>
                                        <span class="float-right mr-2 badge badge-secondary">Today</span>
                                    </div>
                                    <div class="card-body">
                                        <div id="patientChart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 col-md-6">
                                <div class="shadow card">
                                    <div class="card-header">
                                        <strong class="mb-0 card-title">Line Chart</strong>
                                        <span class="float-right mr-2 badge badge-light">30 days</span>
                                        <span class="float-right mr-2 badge badge-light">7 days</span>
                                        <span class="float-right mr-2 badge badge-secondary">Today</span>
                                    </div>
                                    <div class="card-body">
                                        <div id="keuanganChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end section -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <x-footer>
        @push('scripts')
            <!-- Data untuk chart -->
            <script id="chart-data" type="application/json">
                @json($data)
            </script>

            <script id="chart-keuangan" type="application/json">
                @json($data)
            </script>

            <!-- Memuat file JavaScript terpisah -->
            <script src="{{ asset('assets/dashboard/script.js') }}"></script>
        @endpush
    </x-footer>
</body>
