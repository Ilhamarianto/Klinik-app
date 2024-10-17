<x-header></x-header>
<x-navbar></x-navbar>
<body class="vertical light ">
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
                      <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                      <button type="button" class="mr-2 btn btn-sm"><span class="fe fe-filter fe-16 text-muted"></span></button>
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
                          <small class="mb-1 text-muted">Page Views</small>
                          <h3 class="mb-0 card-title">1168</h3>
                          <p class="mb-0 small text-muted"><span class="fe fe-arrow-down fe-12 text-danger"></span><span>-18.9% Last week</span></p>
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
                          <small class="mb-1 text-muted">Conversion</small>
                          <h3 class="mb-0 card-title">68</h3>
                          <p class="mb-0 small text-muted"><span class="fe fe-arrow-up fe-12 text-warning"></span><span>+1.9% Last week</span></p>
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
                          <p class="mb-0 small text-muted"><span class="fe fe-arrow-up fe-12 text-success"></span><span>37.7% Last week</span></p>
                        </div>
                        <div class="text-right col-4">
                          <span class="sparkline inlinebar"></span>
                        </div>
                      </div> <!-- /. row -->
                    </div> <!-- /. card-body -->
                  </div> <!-- /. card -->
                </div> <!-- /. col -->
              </div> <!-- end section -->
      </main> <!-- main -->
    </div>
</body>

<x-footer>
</x-footer>
