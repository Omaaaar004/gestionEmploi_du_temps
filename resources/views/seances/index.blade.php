@extends('layouts.app')

@section('title', 'Emploi du temps')

@section('style')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css' rel='stylesheet' />
@endsection
@section('content')

    {{-- Filtres --}}
    <div class="card" style="margin-bottom:20px;">
        <form method="GET" action="{{ route('seances.index') }}"
            style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
            <div class="form-group" style="margin:0; flex:1;">
                <label>Filière</label>
                <select name="filiere_id">
                    <option value="">-- Toutes les filières --</option>
                    @foreach ($filieres as $filiere)
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
                    @foreach (['S1', 'S2', 'S3', 'S4', 'S5', 'S6'] as $s)
                        <option value="{{ $s }}" {{ request('semestre') == $s ? 'selected' : '' }}>
                            {{ $s }}</option>
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

    @if($view === 'list')
    <div class="card">
        <div class="card-header">
            <h5>Séances ({{ $seances->count() }})</h5>
            <a href="{{ route('seances.index', request()->only(['filiere_id', 'semestre']) + ['view' => 'calendar']) }}" class="btn btn-secondary">📅 Calendrier</a>
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
                        <th>Semestre</th>
                        <th>Filière</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seances as $seance)
                    <tr>
                        <td>{{ $seance->jour }}</td>
                        <td>{{ $seance->heure_deb }} - {{ $seance->heure_fin }}</td>
                        <td>{{ $seance->module->nom }}</td>
                        <td>{{ $seance->prof->nom }}</td>
                        <td>{{ $seance->semestre }}</td>
                        <td>{{ $seance->filiere->nom }}</td>
                        <td>
                            <a href="{{ route('seances.edit', $seance->id) }}" class="btn btn-primary btn-sm">✏️ Modifier</a>
                            <form action="{{ route('seances.destroy', $seance->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Supprimer cette séance ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Supprimer</button>
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
    <div class="card mb-3">
        <div class="card-header">
            <h5>Calendrier des Séances</h5>
            <a href="{{ route('seances.index', request()->only(['filiere_id', 'semestre']) + ['view' => 'list']) }}" class="btn btn-secondary">📋 Liste</a>
        </div>
    </div>
    <div id='calendar'></div>
    @endif

@endsection

@section('script')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'timeGridWeek',
                locale: 'fr',
                firstDay: 1,
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
                allDaySlot: false,
                height: "auto",

                events: {
                    url: "{{ route('seances.events') }}",
                    method: 'GET',
                    extraParams: {
                        filiere_id: "{{ request('filiere_id') }}",
                        semestre: "{{ request('semestre') }}"
                    }
                },

                eventContent: function(arg) {
                    return {
                        html: `
                    <div style="font-size:11px;">
                        <b>${arg.event.extendedProps.module}</b><br>
                        👨‍🏫 ${arg.event.extendedProps.prof}
                    </div>
                `
                    };
                },

                eventClick: function(info) {
                    window.location.href = '/seances/' + info.event.id + '/edit';
                },

                editable: true,
                selectable: true,
                eventOverlap: true,
            });

            calendar.render();
        });
    </script>
@endsection
