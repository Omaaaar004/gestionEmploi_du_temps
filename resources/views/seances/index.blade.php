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

    <div id='calendar'></div>

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
