@extends('layouts.app')

@section('title','Ajouter Semestre')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajoute un semestre</h2>
        <a href="{{ route('semestres.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('semestres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom de semestre</label>
            <input type="text" name="nom" placeholder="Exemple S1 ou S2 etc..." required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection