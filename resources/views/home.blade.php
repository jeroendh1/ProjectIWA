@extends('layouts.app')


@section('content')
    <h1> home</h1>
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
        a:link, a:visited {
            text-decoration: none;
        }
        a:hover, a:active {
            text-decoration: underline;
        }
        a {
            color: inherit;
            /*font-weight: bold;*/
        }

    </style>


    <div class="container-lg mt-4">
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <table class="table table-responsive mt-4">
                    <thead>
                    <tr>
                        <th>Station naam</th>
                        <th>Land</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

{{--                    Station query string--}}
                    @if (isset($_GET['station']))
                        @foreach($malfunctions as $malfunction)
                            @if ($_GET['station'] == $malfunction->stn_name)
                                @if ($malfunction->longitude == 0.9999)
                                    <tr style="color: #ff0000">
                                        <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                        <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                        <td><a href="/home?status=Storing">Storing</a></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                        <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                        <td><a href="/home?status=Ok">In werkende staat</a></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

{{--                        Country query string--}}
                    @elseif (isset($_GET['country']))
                        @foreach($malfunctions as $malfunction)
                            @if ($_GET['country'] == $malfunction->country)
                                @if ($malfunction->longitude == 0.9999)
                                    <tr style="color: #ff0000">
                                        <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                        <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                        <td><a href="/home?status=Storing">Storing</a></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                        <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                        <td><a href="/home?status=Ok">In werkende staat</a></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

{{--                        Status query string--}}
                    @elseif (isset($_GET['status']))
                        @foreach($malfunctions as $malfunction)
                            @if ($_GET['status'] == "Storing" and $malfunction->longitude == 0.9999)
                                    <tr style="color: #ff0000">
                                        <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                        <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                        <td><a href="/home?status=Storing">Storing</a></td>
                                    </tr>
                            @elseif ($_GET['status'] == "Ok" and $malfunction->longitude != 0.9999)
                                <tr>
                                    <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                    <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                    <td><a href="/home?status=Ok">In werkende staat</a></td>
                                </tr>
                            @endif
                        @endforeach

{{--                        Geen query string--}}
                    @else
                        @foreach($malfunctions as $malfunction)
                            @if ($malfunction->longitude == 0.9999)
                                <tr style="color: #ff0000">
                                    <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                    <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                    <td><a href="/home?status=Storing">Storing</a></td>
                                </tr>
                            @else
                                <tr>
                                    <td><a href="/home?station={{ $malfunction->stn_name }}">{{ $malfunction->stn_name }}</a></td>
                                    <td><a href="/home?country={{ $malfunction->country }}">{{ $malfunction->country }}</a></td>
                                    <td><a href="/home?status=Ok">In werkende staat</a></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
