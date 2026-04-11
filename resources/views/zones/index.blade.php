@extends('layouts.app')

@section('title', 'Zones')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des Zones</h2>
        <a href="{{ route('zones.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Code de zone</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($zones as $zone)
            <tr>
                <td>{{ $zone->id }}</td>
                <td>{{ $zone->nom_zone }}</td>
                <td>{{ $zone->code_zone }}</td>
                <td>{{ $zone->description }}</td>
                <td>
                    <a href="{{ route('zones.edit', $zone->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('zones.destroy', $zone->id) }}" method="POST" style="display: inline" onsubmit="return confimr('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;color: #999;padding: 20px;">Aucune zone trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection