@extends('layouts.app')

@section('title', 'Page non trouvée')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4 text-danger">404</h1>
    <p class="lead">Oups… La page que vous cherchez n’existe pas.</p>
    <a href="{{ url('/') }}" class="btn btn-success mt-3">Retour à l’accueil</a>
</div>
@endsection
