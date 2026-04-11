@extends('layouts.app')


@section('title', 'Ajouter composante')


@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>❌ {{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="card">
    <div class="card-header">
        <a href="{{ route('composantes.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('composantes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom de la composantes" >
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="adresse" placeholder="Adresse">
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection