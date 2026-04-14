@extends('layouts.app')

@section('title','Modifier Professeur')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier les données du professeur</h2>
        <a href="{{ route('profs.index') }}" class="btn btn-primary">
             ← Retour
        </a>
    </div>
    <form action="{{ route('profs.update', $prof->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $prof->nom }}" required>
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" value="{{ $prof->prenom }}" required>
        </div>
        <div class="form-group">
            <label>Spécialité</label>
            <input type="text" name="specialite" value="{{ $prof->specialite }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $prof->email }}">
        </div>
        <div class="form-group">
            <label>Département</label>
            <select name="departement_id">
                <option value="">-- Choisir un département --</option>
                @foreach($departements as $departement)
                <option value="{{ $departement->id }}" {{$prof->departement_id == $departement->id ? 'selected' : '' }}>
                    {{ $departement->nom }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection