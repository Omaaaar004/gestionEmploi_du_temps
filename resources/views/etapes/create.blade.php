@extends('layouts.app')

@section('title','Ajouter Étapes')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter une étape</h2>
        <a href="{{ route('etapes.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('etapes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Ex: Semestre 1" required>
        </div>
        <div class="form-group">
            <label>Niveau</label>
            <input type="text" name="niveau" placeholder="Ex: 1ère année" required>
        </div>
        <div class="form-group">
            <select name="filiere_id" required>
                <option value="">-- Choisiser une filière --</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection
