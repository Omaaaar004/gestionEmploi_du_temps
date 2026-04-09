@extends('layouts.app')


@section('title', 'Composantes')


@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('composantes.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('composantes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom de la composantes" required>
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="adresse" placeholder="Adresse">
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection