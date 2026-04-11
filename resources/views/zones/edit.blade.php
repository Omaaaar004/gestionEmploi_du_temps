@extends('layouts.app')

@section('title','Modifier Zone')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier la zone</h2>
        <a href="{{ route('zones.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('zones.update', $zone->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom_zone" value="{{ $zone->nom_zone }}" required>
        </div>
        <div class="form-group">
            <label>Code de la zone</label>
            <input type="text" name="code_zone" value="{{ $zone->code_zone }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" value="{{ $zone->description }}" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection