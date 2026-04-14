@extends('layouts.app')

@section('title', 'Ajouter Département')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter un Département</h2>
        <a href="{{ route('departements.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('departements.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom du département" required>
        </div>
        <div class="form-group">
            <label>Composante</label>
            <select name="composante_id" required>
                <option value="">-- Choisir une composante --</option>
                @foreach($composantes as $composante)
                    <option value="{{ $composante->id }}">{{ $composante->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection