@extends('layouts.app')

@section('title', 'Locaux')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des locaux</h2>
        <a href="{{ route('locals.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom du local</th>
                <th>Capacité</th>
                <th>Zone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($locals as $local)
            <tr>
                <td>{{ $local->id }}</td>
                <td>{{ $local->nom_local}}</td>
                <td>{{ $local->capacite ? $local->capacite : "-" }}</td>
                <td>{{ $local->zone->nom_zone }}</td>
                <td>
                    <a href="{{ route('locals.edit', $local->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('locals.destroy', $local->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            🗑️ Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #999; padding: 20px;">Aucun local trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection