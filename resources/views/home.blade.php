@extends('layouts.app')


@section('content')
    <h1> home</h1>
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
{{--    <table border="1px">--}}
{{--        <tr>--}}
{{--            <td>Code</td>--}}
{{--            <td>Naam</td>--}}
{{--        </tr>--}}
{{--        @foreach ($countries as $country)--}}
{{--            <tr>--}}
{{--                <td>{{ $country->country_code }}</td>--}}
{{--                <td>{{ $country->country }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}

    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>


    <div class="container-lg mt-4">
{{--        <form action="/action_page.php">--}}
{{--            <label for="cars">Choose a car:</label>--}}
{{--            <select name="cars" id="cars">--}}
{{--                @foreach($countries as $country)--}}
{{--                    <option value="{{$country}}">{{$country}}</option>--}}
{{--            </select>--}}
{{--            <br><br>--}}
{{--            <input type="submit" value="Submit">--}}
{{--        </form>--}}
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <table class="table table-responsive mt-4">
                    <thead>
                    <tr>
                        <th>Station naam</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($malfunctions as $malfunction)
                        @if ($malfunction->longitude == 0.9999)

                        <tr style="color: #ff0000">
                            <td>{{ $malfunction->stn_name }}</td>
                            <td> Storing </td>
                        </tr>

                        @endif
                        @if ($malfunction->longitude != 0.9999)

                        <tr>
                            <td>{{ $malfunction->stn_name }}</td>
                            <td> In werkende staat </td>
                        </tr>

                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
