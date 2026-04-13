@extends('layouts.app')

@section('title', 'Ajouter un local')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter un local</h2>
        <a href="{{ route('locals.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('locals.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom du local</label>
            <input type="text" name="nom_local" placeholder="Nom du local">
        </div>
        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacite" placeholder="Capacité du local">
        </div>
        <div class="form-group">
            <label>Zone</label>
            <select name="zone_id" required>
                <option value="">-- Choisissez une zone --</option>
                @foreach($zones as $zone)
                <option value="{{ $zone->id }}">{{ $zone->nom_zone }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection