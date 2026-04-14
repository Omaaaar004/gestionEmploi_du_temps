@extends('layouts.app')

@section('title', 'Ajouter les filières')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter une filière</h2>
        <a href="{{ route('filieres.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('filieres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom de la filière">
        </div>
        <div class="form-group">
            <label>Type Formation</label>
            <select name="type_formation">
                <option value="">-- Choisir --</option>
                <option value="Licence">Licence</option>
                <option value="Master">Master</option>
                <option value="Doctorat">Doctorat</option>
            </select>
        </div>
        <div class="form-group">
            <label>Département</label>
            <select name="departement_id" required>
                <option value="">-- Choisir un département --</option>
                @foreach($departements as $departement)
                    <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                @endforeach    
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection