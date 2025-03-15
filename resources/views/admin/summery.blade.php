<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('protocol') }}" class="text-decoration-none text-dark">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">

            <div class="content-left">
              <span>Total Protocol</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ \App\Models\Protocol::count() }}</h4>
              </div>
            </div>

            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-copy bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('sample.index') }}" class="text-decoration-none text-dark">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Total Sample</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ \App\Models\Sample::count() }}</h4>
              </div>
            </div>
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bx-list-check bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('product') }}" class="text-decoration-none text-dark">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>Total Product</span>
                <div class="d-flex align-items-end mt-2">
                  <h4 class="mb-0 me-2">{{ \App\Models\Product::count() }}</h4>
                </div>
              </div>
              <span class="badge bg-label-danger rounded p-2">
                <i class="bx bx-map-alt bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
    </a>
      </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('sample.report.index') }}" class="text-decoration-none text-dark">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Total Report</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ \App\Models\SampleReport::count() }}</h4>
              </div>
            </div>
            <span class="badge bg-label-warning rounded p-2">
              <i class="bx bx-carousel bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </a>
    </div>
  </div>
