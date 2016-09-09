@extends('layouts.dashboard')

@section('title')
    Topics Status
@endsection

@section('body')
    <canvas id="chart" width="400" height="400"></canvas>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.min.js"></script>
<script>
    var ctx = $("#chart");
    var myPieChart = new Chart(ctx,{
        type: 'pie',
        data: {!! json_encode($chart,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!},
        options: {},
    });

</script>
@endpush
