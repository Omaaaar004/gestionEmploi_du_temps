@extends('layouts.app')

@section('title', 'Modifier Filière')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier la filière</h2>
        <a href="{{ route('filieres.index') }}"class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('filieres.update', $filiere->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom de la filière</label>
            <input type="text" name="nom" value="{{ $filiere->nom }}" required>
        </div>
        <div class="form-group">
            <label>Type Formation</label>
            <select name="type_formation">
                <option value="">-- Choisir --</option>
                <option value="Licence" {{ $filiere->type_formation == 'License' ? 'selected' : '' }}>Licence</option>
                <option value="Master" {{ $filiere->type_formation == 'Master' ? 'selected' : '' }}>Master</option>
                <option value="Doctorat" {{ $filiere->type_formation == 'Doctorat' ? 'select' : '' }}>Doctorat</option>
            </select>
        </div>
        <div class="form-group">
            <label>Département</label>
            <select name="departement_id">
                <option value="">-- Choisir un département --</option>
                @foreach($departements as $departement)
                    <option value="{{ $departement->id }}" {{$filiere->departement_id == $departement->id ? 'selected' : ''}}>
                        {{ $departement->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection