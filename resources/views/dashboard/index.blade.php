@extends('layouts.dashboard')

@section('content')

<!-- Area Chart Example-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fa fa-area-chart"></i> Stock Chart per week</div>
  <div class="card-body">
    <canvas id="myAreaChart" width="100%" height="30"></canvas>
  </div>
  <div class="card-footer small text-muted">
    Updated everyday
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <!-- Example Bar Chart Card-->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-bar-chart"></i> Stock Chart per month</div>
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
      <div class="card-footer small text-muted">
        For last 6 months
      </div>
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

@section('script')
<script>

// -- Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [
      "{{ \Carbon\Carbon::now()->subDay(6)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->subDay(5)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->subDay(4)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->subDay(3)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->subDay(2)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->subDay(1)->englishDayOfWeek }}",
      "{{ \Carbon\Carbon::now()->englishDayOfWeek }}"

    ],
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [{{ $stuff_date[6] }}, {{ $stuff_date[5] }}, {{ $stuff_date[4] }}, {{ $stuff_date[3] }}, {{ $stuff_date[2] }}, {{ $stuff_date[1] }}, {{ $stuff_sum }}],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: {{ $stuff_sum }},
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

// -- Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [
      "{{ \Carbon\Carbon::now()->subMonthsNoOverflow(5)->englishMonth }}",
      "{{ \Carbon\Carbon::now()->subMonthsNoOverflow(4)->englishMonth }}",
      "{{ \Carbon\Carbon::now()->subMonthsNoOverflow(3)->englishMonth }}",
      "{{ \Carbon\Carbon::now()->subMonthsNoOverflow(2)->englishMonth }}",
      "{{ \Carbon\Carbon::now()->subMonthsNoOverflow(1)->englishMonth }}",
      "{{ \Carbon\Carbon::now()->englishMonth }}"
    ],
    datasets: [{
      label: "Stock",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [
        {{ $stuff_date['m5'] }},
        {{ $stuff_date['m4'] }},
        {{ $stuff_date['m3'] }},
        {{ $stuff_date['m2'] }},
        {{ $stuff_date['m1'] }},
        {{ $stuff_sum }}],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: {{ $stuff_sum }},
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

// -- Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Stock", "Drop"],
    datasets: [{
      data: [{{ $stuff_sum }}, {{ $drop_sum }}],
      backgroundColor: ['#007bff', '#dc3545'],
    }],
  },
});
</script>
@endsection
