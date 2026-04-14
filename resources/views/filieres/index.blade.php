@extends('layouts.app')

@section('title','Filières')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des filières</h2>
        <a href="{{ route('filieres.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <th>#</th>
            <th>Nom de la filière</th>
            <th>Type de formation</th>
            <th>Departement</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @forelse($filieres as $filiere)
            <tr>
                <td>{{ $filiere->id }}</td>
                <td>{{ $filiere->nom }}</td>
                <td>{{ $filiere->type_formation ?? '-' }}</td>
                <td>{{ $filiere->departement->nom }}</td>
                <td>
                    <a href="{{ route('filieres.edit', $filiere->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('filieres.destroy', $filiere->id) }}" method="POST" style="display: inline" onsubmit="return confirm('supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding:20px;">Aucune filière trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection