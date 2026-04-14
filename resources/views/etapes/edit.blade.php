@extends('layouts.app')

@section('title', 'Modifier Étape')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier l'Étape</h2>
        <a href="{{ route('etapes.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('etapes.update', $etape->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $etape->nom }}" required>
        </div>
        <div class="form-group">
            <label>Niveau</label>
            <input type="text" name="niveau" value="{{ $etape->niveau }}" required>
        </div>
        <div class="form-group">
            <label>Filière</label>
            <select name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ $etape->filiere_id == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection