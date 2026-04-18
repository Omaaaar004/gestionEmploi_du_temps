@extends('layouts.app')

@section('title','Semestres')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des semestres</h2>
        <a href="{{ route('semestres.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <th>#</th>
            <th>Nom</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @forelse($semestres as $semestre)
                <tr>
                    <td>{{ $semestre->id }}</td>
                    <td>{{ $semestre->nom }}</td>
                    <td>
                        <a href="{{ route('semestres.edit', $semestre->id) }}" class="btn btn-primary">✏️ Modifier</a>
                        <form action="{{ route('semestres.destroy', $semestre->id) }}" method="POST" onsubmit="return confirm('supprimer ?')" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">🗑️ Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;color:#999; paddong:20px;">Aucun semestre trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection