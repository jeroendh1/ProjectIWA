@extends('layouts.app')


@section('content')
    <h1> home</h1>
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
    <table border="1px">
        <tr>
            <td>Code</td>
            <td>Naam</td>
        </tr>
        @foreach ($countries as $country)
            <tr>
                <td>{{ $country->country_code }}</td>
                <td>{{ $country->country }}</td>
            </tr>
        @endforeach
    </table>
@endsection
