@extends('layouts.app')

@section('title', 'Modifier Séance')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier la Séance</h2>
        <a href="{{ route('seances.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Jour</label>
            <select name="jour" required>
                <option value="">-- Choisir un jour --</option>
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
                    <option value="{{ $jour }}" {{ $seance->jour == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Heure Début</label>
            <input type="time" name="heure_deb" value="{{ $seance->heure_deb }}" required>
        </div>
        <div class="form-group">
            <label>Heure Fin</label>
            <input type="time" name="heure_fin" value="{{ $seance->heure_fin }}" required>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre">
                <option value="">-- Choisir --</option>
                @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                    <option value="{{ $s }}" {{ $seance->semestre == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Module</label>
            <select name="module_id" required>
                <option value="">-- Choisir un module --</option>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ $seance->module_id == $module->id ? 'selected' : '' }}>{{ $module->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Professeur</label>
            <select name="prof_id" required>
                <option value="">-- Choisir un professeur --</option>
                @foreach($profs as $prof)
                    <option value="{{ $prof->id }}" {{ $seance->prof_id == $prof->id ? 'selected' : '' }}>{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Filière</label>
            <select name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ $seance->filiere_id == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection