@extends('layouts.app')

@section('title','Modifier Semestre')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier le semestre</h2>
        <a href="{{ route('semestres.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('semestres.update', $semestre->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Filière</label>
            <select name="filiere_id" required>
                <option value="">-- Choisir une filière</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <input type="text" value="{{ $semestre->nom }}" name="nom" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection