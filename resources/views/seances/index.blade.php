@extends('layouts.app')

@section('title', 'Emploi du temps')

@section('content')

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('seances.index') }}" style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
        <div class="form-group" style="margin:0; flex:1;">
            <label>Filière</label>
            <select name="filiere_id">
                <option value="">-- Toutes les filières --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0; flex:1;">
            <label>Semestre</label>
            <select name="semestre">
                <option value="">-- Tous --</option>
                @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                    <option value="{{ $s }}" {{ request('semestre') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
            <a href="{{ route('seances.index') }}" class="btn" style="background:#757575; color:white;">✖ Reset</a>
            <a href="{{ route('seances.create') }}" class="btn btn-primary">+ Ajouter</a>
        </div>
    </form>
</div>

{{-- Grille --}}
<div class="card" style="overflow-x:auto;">
    <div class="card-header">
        <h2>Grille Emploi du Temps</h2>
    </div>
    @php
    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $heures = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
    $couleurs = ['#e3f2fd','#f3e5f5','#e8f5e9','#fff3e0','#fce4ec','#e0f7fa'];
    $moduleColors = [];
    $colorIndex = 0;
@endphp

<table style="width:100%; border-collapse:collapse; min-width:800px; font-size:11px;">
    <thead>
        <tr>
            <th style="background:#1a237e; color:white; padding:8px; width:70px;">Jour</th>
            @foreach($heures as $i => $heure)
                @php $prochaine = isset($heures[$i+1]) ? $heures[$i+1] : '18:00'; @endphp
                <th style="background:#1a237e; color:white; padding:6px; text-align:center; font-size:10px;">
                    {{ $heure }}<br><span style="opacity:0.7;">{{ $prochaine }}</span>
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($jours as $jour)
        <tr>
            <td style="padding:6px; background:#f5f5f5; font-weight:bold; color:#1a237e; border:1px solid #eee; text-align:center;">
                {{ $jour }}
            </td>
            @foreach($heures as $heure)
                @php
                    $seancesDuCreneau = $seances->filter(function($s) use ($jour, $heure) {
                        return $s->jour == $jour &&
                               substr($s->heure_deb, 0, 5) == $heure;
                    });
                @endphp
                <td style="padding:3px; border:1px solid #eee; vertical-align:top; height:50px; min-width:80px;">
                    @foreach($seancesDuCreneau as $seance)
                        @php
                            if(!isset($moduleColors[$seance->module_id])) {
                                $moduleColors[$seance->module_id] = $couleurs[$colorIndex % count($couleurs)];
                                $colorIndex++;
                            }
                            $color = $moduleColors[$seance->module_id];
                        @endphp
                        <div style="background:{{ $color }}; border-radius:4px; padding:3px 5px; border-left:3px solid #1a237e; font-size:10px;">
                            <div style="font-weight:bold; color:#1a237e;">{{ $seance->module->nom }}</div>
                            <div style="color:#555;">👨‍🏫 {{ $seance->prof->nom }}</div>
                            <div style="color:#777;">{{ substr($seance->heure_deb,0,5) }}-{{ substr($seance->heure_fin,0,5) }}</div>
                            <div style="display:flex; gap:3px; margin-top:2px;">
                                <a href="{{ route('seances.edit', $seance->id) }}" style="color:#1a237e; font-size:10px; text-decoration:none;">✏️</a>
                                <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background:none; border:none; cursor:pointer; font-size:10px; color:#e53935; padding:0;">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
   
</div>
@endsection