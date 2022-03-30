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
                        <div class="col-sm-8"><h2>Abonnement <b>Gegevens</b></h2></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info float-end " data-bs-toggle="collapse"
                                    data-bs-target="#addabonnement" aria-expanded="false" aria-controls="addabonnement">
                                Nieuw
                                abonnement
                            </button>

                        </div>
                        <div class="collapse" id="addabonnement">
                            <div class="card card-body">
                                <form method="post" action="{{route('addAbonnement-form-submit')}}" class="">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-sm-4">
                                            <label for="user_id" class="form-label">Klantnummer</label>
                                            <input type="text" name="user_id" class="form-control"
                                                   id="user_id" >
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="user_email" class="form-label">Klant email</label>
                                            <input type="email" name="user_email" class="form-control"
                                                   id="user_email" >
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="start_date" class="form-label">Start datum</label>
                                            <input type="date" name="start_date" class="form-control"
                                                   id="start_date" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="end_date" class="form-label">Eind datum</label>
                                            <input type="date" name="end_date" class="form-control"
                                                   id="end_date" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">Type</label>
                                            <select name="abonnement_type" id="abonnement_type" class="form-select" aria-label=".form-select-sm">
                                                <option selected>Kies abonnement type</option>
                                                @foreach($abonnement_types as $abonnement_type)
                                                    <option value="{{$abonnement_type->id}}">{{$abonnement_type->type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 offset-8 col-sm-4">
                                            <input type="submit" value="Gebruiker toevoegen" name="create_user"
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
                        <th>Klant</th>
                        <th>Abonnement type</th>
                        <th>Gebruikers naam</th>
                        <th>Begindatum</th>
                        <th>Einddatum</th>
                        <th>Actie</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($abonnementen as $abonnement)
                        <tr>
                            <td>{{$abonnement->abonnement_id}}</td>
                            <td>{{$abonnement->email}}</td>
                            <td>{{$abonnement->type}}</td>
                            <td>{{$abonnement->username}}</td>
                            <td>{{$abonnement->start_date}}</td>
                            <td>{{$abonnement->end_date}}</td>
                            <td>
                                {{--                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>--}}
                                <a data-bs-toggle="collapse" data-bs-target="#rowCollapse{{$abonnement->abonnement_id}}" aria-expanded="false" aria-controls="rowCollapse{{$abonnement->id}}" class="edit" title="Edit"><i class="material-icons">&#xE254;</i></a>
                                <a class="delete" title="Delete"><i class="material-icons">&#xE872;</i></a>
                            </td>
                        </tr>
                        <td colspan="12" class="hiddenRow">
                        <div class="collapse" id="rowCollapse{{$abonnement->abonnement_id}}">
                            <form method="post" action="{{route('checklogin')}}" class="">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-sm-4">
                                        <label for="start_date" class="form-label">start date</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date" value="{{$abonnement->start_date}}"
                                               required>
                                    </div>
                                    <div class="mb-3 col-sm-4">
                                        <label for="end_date" class="form-label">end date</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date" value="{{$abonnement->end_date}}"
                                               required>
                                    </div>
                                    <div class="mb-3 col-sm-4">
                                        <label for="abonnement_type" class="form-label">Abonnement type</label>
                                        <input type="number" name="abonnement_type" class="form-control" value="{{$abonnement->type}}"
                                               id="abonnement_type" required>
                                    </div>
                                    <div class="mb-3 offset-9 col-sm-3">
                                        <input type="submit" value="login" name="Login"
                                               class="btn btn-primary float-end"/>
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
