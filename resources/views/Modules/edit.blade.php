@extends('layouts.app')

@section('title', 'Modifier Module')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier le module</h2>
        <a href="{{ route('modules.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('modules.update', $module->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="{{ $module->nom }}" required>
        </div>
        <div class="form-group">
            <label>Étape</label>
            <select name="etape_id" required>
                <option value="">-- Choisir une étape --</option>
                @foreach($etapes as $etape)
                    <option value="{{ $etape->id }}" {{ $module->etape_id == $etape->id ? 'selected' : '-' }}>
                        {{ $etape->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>
</div>
@endsection