@extends('layouts.app')

@section('title','Composantes')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des Composantes</h2>
        <a href="{{ route('composantes.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($composantes as $composante)
            <tr>
                <td>{{ $composante->id }}</td>
                <td>{{ $composante->nom }}</td>
                <td>{{ $composante->adresse}}</td>
                <td>
                    <a href="{{ route('composantes.edit', $composante->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('composantes.destroy', $composante->id) }}" method="POST" style="display: inline" onsubmit="return confirm('supprimer !')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            <tr>
                @empty
                <td colspan="4" style="text-align: center; color: #999; padding: 20px;">
                    Aucune composante trouvée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection