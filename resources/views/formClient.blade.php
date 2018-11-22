@extends('layouts.master')
@section('content')
    {!! Form::open(['url' => 'postClient']) !!}
    <br><br>
    <div class="col-md-12 col-sm-12 well well-md">
        <h1></h1>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Nom : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="nom" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Prenom : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="prenom" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Adresse : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="adr" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Code postal : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="cp" value="" minlength="5" maxlength="5" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Telephone : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="tel" value="" minlength="10" maxlength="10" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Mail : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="email" name="mail" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Login : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="text" name="login" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label">Mot de passe : </label>
                <div class="col-md-2 col-sm-2">
                    <input type="password" name="mdp" value="" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <button type="submit" class="btn btn-default btn-success">
                        <span class="glyphicon glyphicon-ok"></span> Valider
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-default btn-danger" onclick="javascript:if(confirm('Vous êtes sûr ?')) window.location = '{{ url('/') }}';">
                        <span class="glyphicon glyphicon-remove"></span> Annuler
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
                @include('error')
            </div>
        </div>
    </div>