{{-- @extends('admin.layouts.master')

@section('content')

<div class="row mt-3">
    <div class="col-md-2 mt-2">
      <h4 class="fw-bold">Database</h4>
    </div>
    <div class="col-md 8"></div>
    <div class="col-md-2"></div>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table class="invoice-list-table table border-top">
      <thead>
        <tr>
          <th>Product</th>
          <th>Withdrawal date</th>
          <th>Strength</th>
          <th>Unit Pack</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @php
          $today = \Carbon\carbon::today()->addDays(10);
          $warnDate = $today->toDateString();
        @endphp
        @forelse($samples as $report)
        <tr>
          <td>{{ $report->sampleReport->sample->product->ProductName }}</td>
          <td>
              @if (isset($report->TestID) && $report->TestID == '7')
                @foreach ($report->Value as $date)
                  @php
                    $diff = date_diff(date_create($warnDate),date_create($date));
                    $days = $diff->format('%a');
                  @endphp
                  @if ($days <= 10)
                    <p style="color:red;">{{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</p>
                  @else
                    {{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}
                  @endif <br>
                @endforeach
              @endif
          </td>
          <td>{{ \App\Models\ProductDetail::where('SkuID',$report->sampleReport->SkuID)->value('ProductStrength') }} mg</td>
          <td>{{ \App\Models\Pack::where('PackID',$report->sampleReport->PackID)->value('PackValue') }}</td>
        </tr>
        @empty
         <p>No data found!</p>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection --}}

@extends('admin.layouts.master')

@push('style')
    <style type="text/css">
        .my-active span {
            background-color: #5cb85c !important;
            color: white !important;
            border-color: #5cb85c !important;
        }

        ul.pager>li {
            display: inline-flex;
            padding: 5px;
        }

        blockquote {
            margin: 0 0 1rem;
            display: block;

            padding: 5px;

            font-size: 20px;
            border-left: 5px solid gray;
        }
    </style>
@endpush

@section('content')
    <h4>Search database</h4>

    <form action="{{ route('database.index') }}" method="get" class="mb-3">
        <div class="row">
            <div class="col-md-11">
                <input type="text" name="q" placeholder="Search by batch no or month..." class="form-control">
            </div>
            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Batch No</th>
                        <th>Stability Initiation date</th>
                        <th>Withdrawal date</th>
                        <th>Strength</th>
                        <th>Unit Pack</th>
                        <th>Month</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $today = \Carbon\carbon::today()->addDays(30);
                        $warnDate = $today->toDateString();
                    @endphp
                    @forelse($batches as $batch)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $batch->product->ProductName }}</td>
                            <td>{{ $batch->BatchNo }}</td>

                            @php
                                $sidate = new \Carbon\Carbon($batch->SIDate);
                                $stabilty_initiation_date = $sidate->subMonths($batch->Month);
                            @endphp

                            <td>{{ \Carbon\Carbon::parse($stabilty_initiation_date)->toFormattedDateString() }}</td>
                            <td>
                                @php
                                    $diff = date_diff(date_create($warnDate), date_create($batch->SIDate));
                                    $days = $diff->format('%a');
                                @endphp
                                @if ($days <= 30)
                                    <span
                                        style="color:red;">{{ \Carbon\Carbon::parse($batch->SIDate)->toFormattedDateString() }}</span>
                                @else
                                    {{ \Carbon\Carbon::parse($batch->SIDate)->toFormattedDateString() }}
                                @endif
                                <br>
                            </td>
                            <td>{{ \App\Models\ProductDetail::where('SkuID', $batch->SkuID)->value('ProductStrength') }} mg
                            </td>
                            <td>{{ $batch->PackID }}</td>
                            <td>{{ $batch->Month }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center mt-4">
        {!! $batches->withQueryString()->links('pagination.custom') !!}
    </div>
@endsection
