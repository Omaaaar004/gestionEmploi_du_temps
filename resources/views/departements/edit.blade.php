@extends('layouts.app')

@section('title', 'Modifier Département')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier le Département</h2>
        <a href="{{ route('departements.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('departements.update', $departement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $departement->nom }}" required>
        </div>
        <div class="form-group">
            <label>Composante</label>
            <select name="composante_id" required>
                <option value="">-- Choisir une composante --</option>
                @foreach($composantes as $composante)
                    <option value="{{ $composante->id }}" {{ $departement->composante_id == $composante->id ? 'selected' : '' }}>
                        {{ $composante->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection