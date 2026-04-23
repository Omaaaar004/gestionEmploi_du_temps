@extends('layouts.app')

@section('title', 'Emploi du temps')

@section('style')
<style>
.timetable-wrapper {
    overflow-x: auto;
}
.timetable {
    width: 100%;
    min-width: 800px; /* Réduit pour mieux tenir sur l'écran */
    font-size: 11px; /* Texte légèrement plus petit */
    table-layout: fixed;
}
.timetable th {
    background: #1a237e;
    color: white;
    text-align: center;
    padding: 6px 2px;
    font-weight: 600;
    border: 1px solid #283593;
}
.timetable td {
    border: 1px solid #e0e0e0;
    vertical-align: top;
    padding: 0;
    height: 80px; /* Hauteur réduite */
    background: #fafafa;
}
.timetable .time-col {
    background: #f5f5f5;
    color: #1a237e;
    font-weight: 600;
    text-align: center;
    padding: 8px 5px;
    font-size: 12px;
    width: 100px;
    border: 1px solid #e0e0e0;
}
.seance-cell {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    color: white;
    border-radius: 6px;
    margin: 2px;
    padding: 5px;
    font-size: 10px;
    line-height: 1.3;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.1s;
    display: block;
    text-decoration: none;
    height: calc(100% - 8px);
    overflow: hidden;
}
.seance-cell:hover {
    opacity: 0.88;
    transform: scale(1.01);
    color: white;
}
.seance-cell strong {
    display: block;
    font-size: 12px;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.seance-cell span {
    opacity: 0.9;
    font-size: 10px;
}

/* Styles spécifiques pour l'impression */
@media print {
    .sidebar, .navbar, .card form, .btn-secondary, .btn-primary, .hamburger, .sidebar-overlay {
        display: none !important;
    }
    .main {
        margin-left: 0 !important;
    }
    .navbar {
        left: 0 !important;
        display: none !important;
    }
    .content {
        margin-top: 0 !important;
        padding: 0 !important;
    }
    body {
        background: white !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    .timetable {
        border: 1px solid #333 !important;
        min-width: 100% !important;
    }
    .timetable th {
        background: #eee !important;
        color: black !important;
        border: 1px solid #333 !important;
    }
    .timetable td {
        border: 1px solid #333 !important;
        background: white !important;
    }
    .seance-cell {
        background: #f0f0f0 !important; /* Gris très clair pour voir la boîte */
        color: black !important;
        border: 1.5px solid #1a237e !important; /* Bordure plus marquée pour la séance */
        box-shadow: none !important;
        padding: 5px !important;
    }
    .seance-cell strong {
        color: #1a237e !important;
        border-bottom: 0.5px solid #ccc !important;
        margin-bottom: 3px !important;
        display: block !important;
    }
    .seance-cell span {
        color: #333 !important;
    }
}
</style>
@endsection

@section('content')

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('seances.index') }}"
        style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
        <div class="form-group" style="margin:0; flex:1;">
            <label>Filière</label>
            <select name="filiere_id">
                <option value="">-- Sélectionner une filière --</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0; flex:1;">
            <label>Semestre</label>
            <select name="semestre_id">
                <option value="">-- Sélectionner un semestre --</option>
                @foreach ($semestres as $semestre)
                    <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                        {{ $semestre->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:10px; align-items:flex-end;">
            <div>
                <label style="display:block;font-size:14px;color:#555;font-weight:500;margin-bottom:8px;">Vue</label>
                <select name="view">
                    <option value="grid" {{ request('view','grid') == 'grid' ? 'selected' : '' }}>📅 Grille</option>
                    <option value="list" {{ request('view') == 'list' ? 'selected' : '' }}>📋 Liste</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
            <a href="{{ route('seances.index') }}" class="btn btn-secondary">✖ Reset</a>
            <button type="button" onclick="window.print()" class="btn btn-secondary" style="background:#455a64; color:white;">🖨️ Imprimer</button>
            <a href="{{ route('seances.create') }}" class="btn btn-primary">+ Ajouter</a>
        </div>
    </form>
</div>

@php
    $aTenteDeFiltrer = request()->has('view');
@endphp

@if(!$aTenteDeFiltrer)
    {{-- État initial : Premier chargement --}}
    <div style="background: #e3f2fd; color: #0d47a1; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #1a237e;">
        ℹ️ <strong>Bienvenue :</strong> Veuillez sélectionner une <strong>filière</strong> et un <strong>semestre</strong> pour afficher l'emploi du temps.
    </div>
@elseif(!request('filiere_id') && !request('semestre_id'))
    {{-- Erreur : Clic sur filtrer sans aucun choix --}}
    <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #d32f2f; border: 1px solid #ffcdd2;">
        🚫 <strong>Erreur :</strong> Vous n'avez rien sélectionné ! Veuillez choisir une filière et un semestre avant de filtrer.
    </div>
@elseif(!request('filiere_id') || !request('semestre_id'))
    {{-- Oubli : Un des deux manque --}}
    <div style="background: #fff3e0; color: #e65100; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #ff9800; border: 1px solid #ffcc80;">
        ⚠️ <strong>Oubli détecté :</strong> 
        @if(!request('filiere_id')) Vous avez oublié de choisir la <strong>Filière</strong>. @endif
        @if(!request('semestre_id')) Vous avez oublié de choisir le <strong>Semestre</strong>. @endif
        Les deux sont obligatoires.
    </div>
@endif

@if(request('view') == 'list')
{{-- ===== VUE LISTE ===== --}}
<div class="card">
    <div class="card-header">
        <h5>Séances ({{ $seances->count() }})</h5>
    </div>
    <div class="card-body">
        @if($seances->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure</th>
                    <th>Module</th>
                    <th>Prof</th>
                    <th>Local</th>
                    <th>Semestre</th>
                    <th>Filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seances as $seance)
                <tr>
                    <td>{{ $seance->jour }}</td>
                    <td>{{ substr($seance->heure_deb,0,5) }} – {{ substr($seance->heure_fin,0,5) }}</td>
                    <td>{{ $seance->module->nom }}</td>
                    <td>{{ $seance->prof->nom }} {{ $seance->prof->prenom }}</td>
                    <td>{{ $seance->local ? $seance->local->nom_local : '—' }}</td>
                    <td>{{ $seance->semestre->nom }}</td>
                    <td>{{ $seance->filiere->nom }}</td>
                    <td>
                        <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-primary btn-sm">✏️</a>
                        <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer cette séance ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-muted">Aucune séance trouvée.</p>
        @endif
    </div>
</div>

@else
{{-- ===== VUE GRILLE : lignes = jours, colonnes = heures ===== --}}
@php
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    // Créneaux horaires d'une heure
    $creneaux = [
        '08:00' => '09:00',
        '09:00' => '10:00',
        '10:00' => '11:00',
        '11:00' => '12:00',
        '12:00' => '13:00',
        '13:00' => '14:00',
        '14:00' => '15:00',
        '15:00' => '16:00',
        '16:00' => '17:00',
        '17:00' => '18:00',
    ];

    // Indexer les séances par jour + créneau de début
    $grid = [];
    foreach ($seances as $seance) {
        $hDeb = substr($seance->heure_deb, 0, 5);
        // On place la séance dans le créneau où elle commence
        foreach ($creneaux as $debut => $fin) {
            if ($hDeb >= $debut && $hDeb < $fin) {
                $grid[$seance->jour][$debut] = $seance;
                break;
            }
        }
    }

    // Fonction pour calculer le nombre de colonnes (colspan)
    function calculateColspan($seance, $creneaux) {
        $hDeb = substr($seance->heure_deb, 0, 5);
        $hFin = substr($seance->heure_fin, 0, 5);
        $count = 0;
        $started = false;
        foreach ($creneaux as $debut => $fin) {
            if ($hDeb >= $debut && $hDeb < $fin) $started = true;
            if ($started) $count++;
            if ($hFin <= $fin) break;
        }
        return max(1, $count);
    }
@endphp

<div class="card">
    <div class="card-header">
        <h5>📅 Grille Emploi du Temps (Jours × Heures)</h5>
        @if(request('filiere_id') && request('semestre_id'))
            <span style="font-size:13px; color:#888;">{{ $seances->count() }} séance(s)</span>
        @endif
    </div>
    <div class="timetable-wrapper">
        <table class="timetable">
            <thead>
                <tr>
                    <th style="width: 100px;">Jours</th>
                    @foreach($creneaux as $debut => $fin)
                        <th>{{ $debut }} - {{ $fin }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($jours as $jour)
                <tr>
                    <td class="time-col">{{ $jour }}</td>
                    @php $skip = 0; @endphp
                    @foreach($creneaux as $debut => $fin)
                        @if($skip > 0)
                            @php $skip--; @endphp
                            @continue
                        @endif

                        @if(isset($grid[$jour][$debut]))
                            @php
                                $s = $grid[$jour][$debut];
                                $colspan = calculateColspan($s, $creneaux);
                                $skip = $colspan - 1;
                            @endphp
                            <td colspan="{{ $colspan }}">
                                <a href="{{ route('seances.edit', $s->id) }}" class="seance-cell">
                                    <strong>{{ $s->module->nom }}</strong>
                                    <span>⏰ {{ substr($s->heure_deb,0,5) }} - {{ substr($s->heure_fin,0,5) }}</span><br>
                                    <span>👨‍🏫 {{ $s->prof->nom }} {{ $s->prof->prenom }}</span><br>
                                    @if($s->local)
                                    <span>🚪 {{ $s->local->nom_local }}</span><br>
                                    @endif
                                    <span>📚 {{ $s->filiere->nom }}</span>
                                </a>
                            </td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
