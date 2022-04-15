@extends('layouts.app')


@section('content')
    <h1> home</h1>
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif

{{--    Style voor rode text bij storingen--}}
{{--    <style>--}}
{{--        .storing {--}}
{{--            color: #f00;--}}
{{--        }--}}
{{--    </style>--}}

    <div class="container-lg mt-4">
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <table class="table table-responsive mt-4">

                    <div class="card card-body">
                        <form method="post" action="{{route('getVariablesFilter')}}" class="">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-sm-4">
                                    <label for="station_naam" class="form-label">Station naam</label>
                                    <select name="station_naam" class="form-control"
                                            id="station_naam">

                                        <option value=null selected></option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->stn_name }}">{{ $station->stn_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-4">
                                    <label for="land" class="form-label">Land</label>
                                    <select name="land" class="form-control"
                                            id="land">

                                        <option value=null selected></option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->country }}">{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-4">
                                    <label for="locatie" class="form-label">Locatie</label>
                                    <select name="locatie" class="form-control"
                                            id="locatie">

                                        <option value=null selected></option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->locality }}">{{ $location->locality }}</option>
                                        @endforeach
                                    </select>
                                </div>
{{--                                Filter voor coördinaten, werkt maar filter is niet nuttig.--}}
{{--                                Om te gebruiken uncomment code in home.blade.php--}}
{{--                                Mist echter longitude en latitude van variabele $station uit getStations() van DashboardController.php--}}

{{--                                <div class="mb-3 col-sm-4">--}}
{{--                                    <label for="coordinaten" class="form-label">Coördinaten</label>--}}
{{--                                    <select name="coordinaten" class="form-control"--}}
{{--                                            id="coordinaten">--}}

{{--                                        <option value=null selected></option>--}}
{{--                                        @foreach($stations as $station)--}}
{{--                                            <option value="{{ $station->longitude }},{{ $station->latitude }}">{{ $station->longitude }},{{ $station->latitude }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <div class="mb-3 col-sm-4">
                                    <label for="Status" class="form-label">Status</label>
                                    <select name="status" class="form-control"
                                            id="status">

                                        <option value=null selected></option>
                                        <option value="ok">In werkende staat</option>
                                        <option value="storing">Storing</option>

                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 offset-4 col-sm-4">
                                <input type="submit" value="filter" name="filter"
                                       class="btn btn-primary mt-4 float-end"/>
                            </div>
                        </form>
                    </div>

                    <thead>
                    <tr>
                        <th>Station naam</th>
                        <th>Land</th>
                        <th>Locatie</th>
                        <th>Coördinaten</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
{{--                        Geen query string--}}
                        @foreach($malfunctions as $malfunction)
                            @if ($malfunction->longitude == 0.9999)
                                <tr class="storing">
                                    <td>{{ $malfunction->station_name }}</td>
                                    <td>{{ $malfunction->country }}</td>
                                    <td>{{$malfunction->locality}}</td>
                                    <td>{{$malfunction->longitude}},{{$malfunction->latitude}}</td>
                                    <td>Storing</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $malfunction->station_name }}</td>
                                    <td>{{ $malfunction->country }}</td>
                                    <td>{{$malfunction->locality}}</td>
                                    <td>{{$malfunction->longitude}},{{$malfunction->latitude}}</td>
                                    <td>In werkende staat</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
