@extends('layouts.dashboard')

@section('content')

<!-- Area Chart Example-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-area-chart"></i> Stock Chart</div>
  <div class="card-body">
    <canvas id="myAreaChart" width="100%" height="30"></canvas>
  </div>
  <div class="card-footer small text-muted"></div>
</div>

<div class="row">
  <div class="col-lg-8">
    <!-- Example Bar Chart Card-->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-bar-chart"></i> Bar Chart</div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-8 my-auto">
            <canvas id="myBarChart" width="100" height="50"></canvas>
          </div>
          <div class="col-sm-4 text-center my-auto">
            <div class="h4 mb-0 text-primary">{{ $stuff_sum + $drop_sum }}</div>
            <div class="small text-muted">Total Stuffs</div>
            <hr>
            <div class="h4 mb-0 text-warning">{{ $stuff_sum }}</div>
            <div class="small text-muted">Stock</div>
            <hr>
            <div class="h4 mb-0 text-success">{{ $drop_sum }}</div>
            <div class="small text-muted">Drop</div>
          </div>
        </div>
      </div>
      <div class="card-footer small text-muted"></div>
    </div>

  </div>
  <div class="col-lg-4">
    <!-- Example Pie Chart Card-->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-pie-chart"></i> Pie Chart</div>
      <div class="card-body">
        <canvas id="myPieChart" width="100%" height="100"></canvas>
      </div>
      <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
  </div>
</div>
@endsection
