@php
use App\Classification;
@endphp

@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Student Evaluation</h1>
        <hr>

        <section>
            
        </section>

        <div class="row">
          <div class="col-6">
            <div class="card h-100 mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Student Classification
                  <button class="float-right" onclick="downloadPDF('chart-classification', 'Student Classification')">
                      <i class="fas fa-download"></i>
                  PDF</button>
                </div>
              <div class="card-body">
                <canvas id="chart-classification" width="100%" height="100"></canvas>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card h-100 mb-3">
              <div class="card-header">
                <i class="fas fa-chart-pie"></i>
                Unit Difficulty
                  <button class="float-right" onclick="downloadPDF('module-classification', 'Unit Difficulty')">
                      <i class="fas fa-download"></i>
                  PDF</button>
                </div>
                <div class="card-body">
                  <canvas id="module-classification" width="100%" height="50"></canvas>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

@push('scripts')

<script type="text/javascript">

  function downloadPDF(id, name) {
    var canvas = document.querySelector('#' + id);
    //creates image
    var canvasImg = canvas.toDataURL("image/png", 1.0);
    
    //creates PDF from img
    var doc = new jsPDF('landscape');
    doc.setFontSize(20);
    doc.text(10, 10, name);
    if (id === 'module-classification') {
      doc.addImage(canvasImg, 'PNG', 70, 20, 160, 120 );
    } else {
      doc.addImage(canvasImg, 'PNG', 50, 20, 200, 180 );
    }
    var fileName = name.replace(' ', '_', name) + '.pdf';
    doc.save(fileName);
  }
    
  var ctx = document.getElementById("chart-classification");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: [
        @foreach (Classification::TYPES as $type)
          "{{ $type }}",
        @endforeach
      ],
      datasets: [{
        data: [
          {{ $classifications[Classification::TYPE_OUTSTANDING]->count() }},
          {{ $classifications[Classification::TYPE_VERY_GOOD]->count() }},
          {{ $classifications[Classification::TYPE_GOOD]->count() }},
          {{ $classifications[Classification::TYPE_AVERAGE]->count() }},
          {{ $classifications[Classification::TYPE_NEEDS_IMPROVEMENT]->count() }},
          {{ $classifications[Classification::TYPE_FAILURE]->count() }},
        ],
        backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#55ce37', '#8637ce', '#ce37a0'],
      }],
    },
  })


var ctx = document.getElementById("module-classification");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [
      @foreach ($moduleClassification as $m)
        "{{ $m['name'] }}",
      @endforeach
    ],
    datasets: [{
      label: "Failing",
      backgroundColor: "#fb4e4e",
      borderColor: "#fb4e4e",
      data: [
        @foreach ($moduleClassification as $m)
          {{ $m['bad'] }},
        @endforeach
      ],
    },
    {
      label: "Good Learners",
      backgroundColor: "#7fc72f",
      borderColor: "#7fc72f",
      data: [
        @foreach ($moduleClassification as $m)
          {{ $m['good'] }},
        @endforeach
      ],
    }],

  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'Unit'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 10
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 20,
          maxTicksLimit: 10
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: true
    }
  }
});




</script>


@endpush