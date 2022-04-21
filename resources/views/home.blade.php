@extends('layouts.app')


@section('content')
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
    <div class="container-lg mt-4">
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <div class="row">
                    <div class="col-sm-8"><h2>Station <b>Gegevens</b></h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info float-end " data-bs-toggle="collapse"
                                data-bs-target="#filter" aria-expanded="true" aria-controls="addabonnement">
                            Open filters
                        </button>

                    </div>
                    <div class="collapse" id="filter">
                        <div class="card card-body">
                            <form method="post" action="{{route('getVariablesFilter')}}" class="">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-sm-3">
                                        <label for="station_naam" class="form-label">Station naam</label>
                                        <input type="text" class="form-control" name="station_naam" id="station_naam">
                                        {{--                                        <select name="station_naam" class="form-control"--}}
                                        {{--                                                id="station_naam">--}}

                                        {{--                                            <option value=null selected>-</option>--}}
                                        {{--                                            @foreach($stations as $station)--}}
                                        {{--                                                <option value="{{ $station->station_id }}">{{ $station->station_id }}</option>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        </select>--}}
                                    </div>
                                    <div class="mb-3 col-sm-3">
                                        <label for="land" class="form-label">Land</label>
                                        <input type="text" class="form-control" name="land" id="land">
                                        {{--                                        <select name="land" class="form-control"--}}
                                        {{--                                                id="land">--}}

                                        {{--                                            <option value=null selected>-</option>--}}
                                        {{--                                            @foreach($countries as $country)--}}
                                        {{--                                                <option value="{{ $country->country }}">{{ $country->country }}</option>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        </select>--}}
                                    </div>
                                    <div class="mb-3 col-sm-3">
                                        <label for="locatie" class="form-label">Locatie</label>
                                        <input type="text " class="form-control" name="locatie" id="locatie">
                                        {{--                                        <select name="locatie" class="form-control"--}}
                                        {{--                                                id="locatie">--}}

                                        {{--                                            <option value=null selected>-</option>--}}
                                        {{--                                            @foreach($locations as $location)--}}
                                        {{--                                                <option value="{{ $location->name }}">{{ $location->name }}</option>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        </select>--}}
                                    </div>
                                    <div class="mb-3 col-sm-3">
                                        <label for="Status" class="form-label">Status</label>
                                        <select name="status" class="form-control"
                                                id="status">

                                            <option value="storing" selected>Storing</option>
                                            <option value="ok">In werkende staat</option>
                                            <option value="alles">Alles weergeven</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 offset-8 col-sm-4">
                                    <input type="submit" value="filter" name="filter"
                                           class="btn btn-primary mt-4 float-end"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table class="table table-responsive mt-4">

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
                        {{--                            @if ($statuses[$malfunction->station_id] == true)--}}
                        <tr>
                            <td><a href="/station/{{ $malfunction->station_id }}">{{ $malfunction->station_id }}</a>
                            </td>
                            <td>{{ $malfunction->country }}</td>
                            <td>{{$malfunction->name}}</td>
                            <td>{{$malfunction->longitude}},{{$malfunction->latitude}}</td>
                            @if($malfunction->original_data_id == null)
                                <td>In werkende staat</td>
                            @else
                                <td class="storing">Storing</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <span class="mb-4">{{$malfunctions->links()}}</span>
            </div>
        </div>
    </div>

@endsection
