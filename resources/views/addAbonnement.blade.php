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
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
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
                                            <label for="customer_id" class="form-label">Klantnummer</label>
                                            <input type="text" name="customer_id" class="form-control"
                                                   id="customer_id" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="customer_email" class="form-label">Klant email</label>
                                            <input type="email" name="customer_email" class="form-control"
                                                   id="customer_email" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="start_date" class="form-label">Start datum</label>
                                            <input type="date" name="start_date" class="form-control"
                                                   id="start_date" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="end_date" class="form-label">Eind datum</label>
                                            <input type="date" name="end_date" class="form-control"
                                                   id="end_date">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">Type</label>
                                            <select name="abonnement_type" id="abonnement_type" class="form-select"
                                                    aria-label=".form-select-sm">
                                                <option selected>Kies abonnement type</option>
                                                @foreach($abonnement_types as $abonnement_type)
                                                    <option
                                                        value="{{$abonnement_type->id}}">{{$abonnement_type->omschrijving}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 offset-8 col-sm-4">
                                            <input type="submit" value="abonnement toevoegen" name="create_user"
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
                            <td>{{$abonnement->omschrijving}}</td>
                            <td>{{$abonnement->start_date}}</td>
                            <td>{{$abonnement->end_date}}</td>
                            <td>
                                {{--                            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>--}}
                                <a data-bs-toggle="collapse" data-bs-target="#rowCollapse{{$abonnement->abonnement_id}}"
                                   aria-expanded="false" aria-controls="rowCollapse{{$abonnement->id}}" class="edit"
                                   title="Edit"><i class="material-icons">&#xE254;</i></a>
                                <a class="delete" title="Delete"
                                   href="{{route('deleteAbonnement', ['abonnement_id'=>$abonnement->abonnement_id])}}"><i
                                        class="material-icons">&#xE872;</i></a>
                            </td>
                        </tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="collapse" id="rowCollapse{{$abonnement->abonnement_id}}">
                                <form method="post"
                                      action="{{route('editAbonnement-form-submit', ['abonnement_id'=>$abonnement->abonnement_id])}}"
                                      class="">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-sm-4">
                                            <label for="start_date" class="form-label">Start datum</label>
                                            <input type="date" name="start_date" class="form-control"
                                                   id="start_date" value="{{$abonnement->start_date}}" required>
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label for="end_date" class="form-label">Eind datum</label>
                                            <input type="date" name="end_date" class="form-control"
                                                   id="end_date" min="{{$abonnement->start_date}}" value="{{$abonnement->end_date}}">
                                        </div>
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">Type</label>
                                            <select name="abonnement_type" id="abonnement_type" class="form-select"
                                                    aria-label=".form-select-sm">
                                                <option
                                                    value="{{$abonnement->id}}">{{$abonnement->omschrijving}}</option>
                                                @foreach($abonnement_types as $abonnement_type)
                                                    <option
                                                        value="{{$abonnement_type->id}}">{{$abonnement_type->omschrijving}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-4 row">
                                            <label for="gt" class="form-label">Token</label>
                                            <div class="col-sm-11">
                                                <input type="text" disabled name="gt" class="form-control"
                                                       id="gt{{$abonnement->abonnement_id}}"
                                                       value="{{$abonnement->token}}">
                                            </div>
                                            <div class="col-sm-1 p-0">
                                                <a onclick="generateToken({{$abonnement->abonnement_id}})"
                                                   id="generateToken" type="button"
                                                   class="generateToken btn centerItem"> <i class="material-icons">
                                                        &#xe5d5;</i> </a>
                                            </div>
                                        </div>
                                        <div class="mb-3 offset-8 col-sm-4">
                                            <input type="submit" value="abonnement bewerken" name="edit_abonnement"
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
    <script>
        function generateToken(id) {
            $.ajax({
                url: '{{route('generateToken')}}',
            }).done(function (result) {
                $("#gt" + id).val(result);
            });
        }
        $("#start_date").on("change", function(){
            $("#end_date").attr("min", $(this).val());
        });
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const inputs = Array.from(
                document.querySelectorAll('input[name=customer_id], input[name=customer_email]')
            );
            const inputListener = e => {
                inputs
                    .filter(i => i !== e.target)
                    .forEach(i => (i.required = !e.target.value.length));
            };
            inputs.forEach(i => i.addEventListener('input', inputListener));
        });
    </script>


@endsection
