@extends('layouts.app')

@section('title', 'Modifier Composante')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier la composante</h2>
        <a href="{{ route('composante.index') }}">← Retour</a>
    </div>
    <form action="{{ route('composante.update', $composante->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $composante->nom }}" required>
        </div>
        <div class="form-group">
            <input type="text" name="adresse" value="{{ $composante->adresse }}" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>