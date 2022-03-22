@extends('layouts.app')


@section('content')
    <h1> home</h1>
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
@endsection
