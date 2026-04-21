@extends('layouts.app')

@section('title', 'Ajouter Module')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter un module</h2>
        <a href="{{ route('modules.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom du module</label>
            <input type="text" name="nom" placeholder="Donner le nom du module" required>
        </div>
        <div class="form-group">
            <label>Étape</label>
            <select name="filiere_id" required>
                <option value="">-- Choisir une Filière --</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre_id" required>
                <option value="">-- Choisir un semestre --</option>
                @foreach($semestres as $semestre)
                <option value="{{ $semestre->id }}">{{ $semestre->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection