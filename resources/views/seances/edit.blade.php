@extends('layouts.app')

@section('title', 'Modifier Séance')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Modifier la Séance</h2>
        <a href="{{ route('seances.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Jour</label>
            <select name="jour" required>
                <option value="">-- Choisir un jour --</option>
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
                    <option value="{{ $jour }}" {{ $seance->jour == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Heure Début</label>
            <input type="time" name="heure_deb" value="{{ $seance->heure_deb }}" required>
        </div>
        <div class="form-group">
            <label>Heure Fin</label>
            <input type="time" name="heure_fin" value="{{ $seance->heure_fin }}" required>
        </div>
        <div class="form-group">
            <label>Filière</label>
            <select id="filiere-select" name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ $seance->filiere_id == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Module</label>
            <select id="module-select" name="module_id" required>
                <option value="">-- Choisir module --</option>
            </select>
        </div>
        <div class="form-group">
            <label>Professeur</label>
            <select name="prof_id" required>
                <option value="">-- Choisir un professeur --</option>
                @foreach($profs as $prof)
                    <option value="{{ $prof->id }}" {{ $seance->prof_id == $prof->id ? 'selected' : '' }}>{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>

    <script>
        const filiereSelect = document.getElementById('filiere-select');
        const etapeSelect = document.getElementById('etape-select');
        const moduleSelect = document.getElementById('module-select');
        const currentModuleId = '{{ $seance->module_id }}';
        
        // Same logic as create
        filiereSelect.addEventListener('change', function() {
            const filiereId = this.value;
            etapeSelect.innerHTML = '<option value="">-- Chargement --</option>';
            etapeSelect.disabled = true;
            moduleSelect.innerHTML = '<option value="">-- Sélectionnez filière + étape --</option>';
            moduleSelect.disabled = true;
            
            if (!filiereId) {
                etapeSelect.innerHTML = '<option value="">-- Choisir après filière --</option>';
                return;
            }
            
            fetch(`/seances/etapes/${filiereId}`)
                .then(response => response.json())
                .then(etapes => {
                    etapeSelect.innerHTML = '<option value="">-- Choisir étape --</option>';
                    etapes.forEach(etape => {
                        const option = document.createElement('option');
                        option.value = etape.id;
                        option.textContent = etape.nom + ' (' + etape.niveau + ')';
                        etapeSelect.appendChild(option);
                    });
                    etapeSelect.disabled = false;
                    // Try to select current etape if known
                });
        });
        
        etapeSelect.addEventListener('change', function() {
            const filiereId = filiereSelect.value;
            const etapeId = this.value;
            if (!filiereId || !etapeId) {
                moduleSelect.innerHTML = '<option value="">-- Sélectionnez filière + étape --</option>';
                moduleSelect.disabled = true;
                return;
            }
            
            fetch(`/seances/modules/${filiereId}/${etapeId}`)
                .then(response => response.json())
                .then(modules => {
                    moduleSelect.innerHTML = '<option value="{{ $seance->module_id }}" selected>' + currentModuleId + '</option>'; // preserve
                    modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.nom;
                        if (module.id == currentModuleId) option.selected = true;
                        moduleSelect.appendChild(option);
                    });
                    moduleSelect.disabled = false;
                });
        });
        
        // Trigger load
        filiereSelect.dispatchEvent(new Event('change'));
    </script>
</div>
@endsection
