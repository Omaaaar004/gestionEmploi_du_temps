@extends('layouts.app')

@section('title', 'Professeurs') 

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des Professeurs</h2>
        <a href="{{ route('profs.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Email</th>
                <th>Département</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profs as $prof)
            <tr>
                <td>{{ $prof->id }}</td>
                <td>{{ $prof->nom }}</td>
                <td>{{ $prof->prenom }}</td>
                <td>{{ $prof->specialite ?? '-' }}</td>
                <td>{{ $prof->email ?? '-' }}</td>
                <td>{{ $prof->departement->nom }}</td>
                <td>
                    <a href="{{ route('profs.edit', $prof->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('profs.destroy', $prof->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Supprimé ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #999; padding: 20px">Aucun professeur trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection