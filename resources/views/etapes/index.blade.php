@extends('layouts.app')

@section('title', 'Étapes')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Listes des Étapes</h2>
        <a href="{{ route('etapes.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Niveau</th>
                <th>Filière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($etapes as $etape)
            <tr>
                <td>{{ $etape->id }}</td>
                <td>{{ $etape->nom }}</td>
                <td>{{ $etape->niveau }}</td>
                <td>{{ $etape->filiere->nom }}</td>
                <td>
                    <a href="{{ route('etapes.edit', $etape->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('etapes.destroy',$etape->id) }}" method="POST" style="display: inline" onsubmit="return confirm('supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#999; padding:20px;">Aucune étape trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection