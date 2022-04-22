@extends('layouts.app')


@section('content')

    @if(isset(Auth::user()->username))
        <script>window.location = "/login/successlogin";</script>
    @endif
    <div class="container-lg mx-auto">
        <div class="row">
            <form method="post" action="{{route('checklogin')}}" class="col-md-4 mx-auto mt-5">
                @csrf
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <h1> Login IWA</h1>
                <hr>
                <div class="mb-3">
                    <label for="Username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="Username" required>
                </div>
                <div class="mb-3">
                    <label for="Password1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="Password1" required>
                </div>
                <input type="submit" value="login" name="Login" class="btn btn-primary"/>
            </form>
        </div>
    </div>
@endsection
