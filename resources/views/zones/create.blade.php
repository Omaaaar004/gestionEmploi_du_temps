@extends('layouts.app')

@section('title', 'Ajouter zone')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>❌ {{ $error }}</p>
        @endforeach
    </div>
@endif
<div class="card">
    <div class="card-header">
        <a href="{{ route('zones.index') }}" class='btn btn-primary'>← Retour</a>
    </div>
    <form action="{{ route('zones.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom_zone" placeholder="Nom de la zone">
        </div>
        <div class="form-group">
            <label>Code de la zone</label>
            <input type="text" name="code_zone" placeholder="Code de la zone">
        </div>    
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" placeholder="Description">
        </div>
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>
</div>
@endsection