@extends('layouts.app')

@section('title', 'Modifier Module')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier le module</h2>
        <a href="{{ route('modules.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('modules.update', $module->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $module->nom }}" required>
        </div>
        <div class="form-gorup">
            <label>Filière</label>
            <select name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}">

                </option>
            </select>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre_id" required>
                <option value="">-- Choisir un semestre --</option>
                @foreach($semestres as $semestre)
                    <option value="{{ $semestre->id }}">
                        {{ $semestre->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection