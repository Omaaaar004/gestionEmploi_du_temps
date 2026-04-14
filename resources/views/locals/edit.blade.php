@extends('layouts.app')

@section('title', 'Modifier Local')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier le local</h2>
        <a href="{{ route('locals.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('locals.update', $local->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom du Local</label>
            <input type="text" name="nom_local" value="{{ $local->nom_local }}">
        </div>
        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacite" value="{{ $local->capacite }}">
        </div>
        <div class="form-group">
            <label>Zone</label>
            <select name="zone_id" required>
                <option value="">-- Choisir une zone --</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ $local->zone_id == $zone->id ? 'selected' : '' }} >
                        {{ $zone->nom_zone }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection