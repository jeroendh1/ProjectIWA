@extends('layouts.app')


@section('content')
    @if(!isset(Auth::user()->username))
        <script>window.location = "/login";</script>
    @endif
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    <div class="container-lg mt-4">
        <div class="table-responsive overflow-hidden">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Medewerker <b>gegevens</b></h2></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info float-end " data-bs-toggle="collapse"
                                    data-bs-target="#adduser" aria-expanded="false" aria-controls="adduser">
                                Nieuwe medewerker
                            </button>

                        </div>
                        <div class="collapse" id="adduser">
                            <div class="card card-body">
                                <form method="post" action="{{route('addUser-form-submit')}}" class="">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-sm-4">
                                            <label for="first_name" class="form-label">Voornaam</label>
                                            <input type="text" name="first_name" class="form-control"
                                                   id="first_name" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="last_name" class="form-label">Achternaam</label>
                                            <input type="text" name="last_name" class="form-control"
                                                   id="last_name" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                   id="email" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="username" class="form-label">Gebruikersnaam</label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                   required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="password" class="form-label">Wachtwoord</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                   required>
                                        </div>

                                        <div class="mb-3 col-sm-4">
                                            <label for="functie" class="form-label">functie</label>
                                            <input type="text" name="functie" class="form-control"
                                                   id="functie" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                                <input class="form-check-input" name="admin" type="checkbox" id="admin">
                                                <label class="form-check-label" for="admin">
                                                    Admin
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3 offset-8 col-sm-4">
                                            <input type="submit" value="Medewerker toevoegen" name="create_user"
                                                   class="btn btn-primary mt-4 float-end"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive mt-4">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Gebruikersnaam</th>
                        <th>Voornaam</th>
                        <th>Achternaam</th>
                        <th>Email</th>
                        <th>Functie</th>
                        <th>Actie</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->user_id}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->functie}}</td>
                            <td>
                                {{--                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>--}}
                                <a data-bs-toggle="collapse" data-bs-target="#rowCollapse{{$user->user_id}}" aria-expanded="false" aria-controls="rowCollapse{{$user->user_id}}" class="edit" title="Edit"><i class="material-icons">&#xE254;</i></a>
                                <a class="delete" href="{{route('deleteUser', ['user_id'=>$user->user_id])}}" title="Delete"><i class="material-icons">&#xE872;</i></a>
                            </td>
                        </tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="collapse" id="rowCollapse{{$user->user_id}}">
                                <form method="post" action="{{route('editUser-form-submit', ['user_id'=>$user->user_id])}}" class="">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-sm-4">
                                            <label for="first_name" class="form-label">Voornaam</label>
                                            <input type="text" name="first_name" class="form-control"
                                                   id="first_name" value="{{$user->first_name}}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="last_name" class="form-label">Achternaam</label>
                                            <input type="text" name="last_name" class="form-control"
                                                   id="last_name" value="{{$user->last_name}}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                   id="email" value="{{$user->email}}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="username" class="form-label">Gebruikersnaam</label>
                                            <input type="text" name="username" class="form-control" id="username"
                                                   value="{{$user->username}}" required>
                                        </div>
{{--                                        <div class="mb-3 col-sm-4">--}}
{{--                                            <label for="password" class="form-label">Wachtwoord</label>--}}
{{--                                            <input type="password" name="password" class="form-control" id="password"--}}
{{--                                                   value="{{$user->password}}" required>--}}
{{--                                        </div>--}}

                                        <div class="mb-3 col-sm-4">
                                            <label for="functie" class="form-label">Land</label>
                                            <input type="text" name="functie" class="form-control"
                                                   id="functie" value="{{$user->functie}}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <input class="form-check-input" name="admin" type="checkbox" id="admin">
                                            <label class="form-check-label" for="admin">
                                                Admin
                                            </label>
                                        </div>

                                        <div class="mb-3 offset-8 col-sm-4">
                                            <input type="submit" value="Bijwerken" name="edit_user"
                                                   class="btn btn-primary mt-4 float-end"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
