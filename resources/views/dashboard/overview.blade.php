@extends('layouts.dashboard')

@section('title')
    Topics Status
@endsection

@section('body')
    <canvas id="chart" width="400" height="400"></canvas>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<script>
    var ctx = $("#chart");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            lables:{!! (json_encode(array_keys($chart),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)) !!},
            datasets: [
                {
                    label: 'Topic',
                    labels:{!! (json_encode(array_values($chart),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                }
            ]
        },
        options: {},
    });

</script>
@endpush
