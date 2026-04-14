@extends('layouts.app')

@section('title', 'Départements')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des Départements</h2>
        <a href="{{ route('departements.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Composante</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departements as $departement)
            <tr>
                <td>{{ $departement->id }}</td>
                <td>{{ $departement->nom }}</td>
                <td>{{ $departement->composante->nom }}</td>
                <td>
                    <a href="{{ route('departements.edit', $departement->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('departements.destroy', $departement->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#999; padding:20px;">Aucun département trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection