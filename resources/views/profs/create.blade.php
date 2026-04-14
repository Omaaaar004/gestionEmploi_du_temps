@extends('layouts.app')

@section('title', 'Ajouter Professeur')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter un professeur</h2>
        <a href="{{ route('profs.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('profs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Saisir le nom du professeur Mr/Mme..." required>
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" placeholder="Saisir le prénom du professeur" required>
        </div>
        <div class="form-group">

        </div>
        <div class="form-group">
            <label>Spécialité</label>
            <input type="text" name="specialite" placeholder="Saisir la spécialité du professeur">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="" placeholder="Email du professeur">
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