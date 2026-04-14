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
            <select name="etape_id" required>
                <option value="">-- Choisir une étape --</option>
                @foreach($etapes as $etape)
                <option value="{{ $etape->id }}">{{ $etape->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection