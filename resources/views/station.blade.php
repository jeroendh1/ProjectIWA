
@extends('layouts.app')


@section('content')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

    <?php
//        echo '<br><br><br><br><br><br>';
//
//    var_dump($charts);
    ?>
    <div class="container-lg mt-4">
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <div class="row">
                    <div class="col-sm-8"><h2>Station's <b>Gegevens</b> van <b>Station</b> {{ $station->station_id }} </h2></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4><b>Land:</b> {{ $station->country }} </h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4><b>Locatie:</b> {{ $station->name }} </h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4><b>Coördinaten:</b> {{ $station->longitude }}, {{ $station->latitude }} </h4></div>
                </div>
                @if ($status == 'Storing')
                <div class="row">
                    <div class="col-sm-4"><h4 class="storing"><b>Status:</b> {{ $status }} </h4></div>
                </div>
                @else
                <div class="row">
                    <div class="col-sm-4"><h4><b>Status:</b> {{ $status }} </h4></div>
                </div>
                @endif
                @if (!$charts)
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="storing"><h4><b>Geen data beschikbaar</b></h4></div>
                        </div>
                    </div>
                @else
                    <div class="container px-4">
                        <div class="row gx-5  bg-opacity-10 ">
                            @foreach($charts as $key => $chart)
{{--                                <div class="col">--}}
{{--                                    <div class="container-fluid border bg-opacity-10 bg-dark">--}}
                                        <canvas id="{{$key}}Chart" style="width:100%;max-width:400px"></canvas>
                                        <script>
                                            var xValues = <?php echo json_encode($chart[0]); ?>;
                                            var yValues = <?php echo json_encode($chart[1]); ?>;
                                            var yLabels = <?php echo json_encode($chart[0]); ?>;

                                            new Chart("{{$key}}Chart", {
                                                type: "line",
                                                data: {
                                                    labels: xValues,
                                                    datasets: [{
                                                        fill: false,
                                                        lineTension: 0,
                                                        backgroundColor: "rgba(255, 255,255,1.0)",
                                                        borderColor: "rgba(0,255,255,1)",
                                                        data: yValues
                                                    }]
                                                },
                                                options: {
                                                    legend: {display: false},
                                                    scales: {
                                                        xAxes: [{
                                                            ticks: {
                                                                beginAtZero: true,
                                                                callback: function(value, index, values) {
                                                                    return yLabels[value];
                                                                }
                                                            }
                                                        }]
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'De {{$key}} van de afgelopen dag'
                                                    }
                                                }
                                            });
                                        </script>
{{--                                    </div>--}}
{{--                                </div>--}}
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
