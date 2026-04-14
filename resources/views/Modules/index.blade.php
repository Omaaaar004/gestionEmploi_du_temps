@extends('layouts.app')

@section('title', 'Modules')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Liste des modules</h2>
        <a href="{{ route('modules.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Étape</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($modules as $module)
            <tr>
                <td>{{ $module->id }}</td>
                <td>{{ $module->nom }}</td>
                <td>{{ $module->etape->nom}}</td>
                <td>
                    <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-primary">✏️ Modifier</a>
                    <form action="{{ route('modules.destroy',$module->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #999; padding: 20px">Aucun module trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
