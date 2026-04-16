@extends('layouts.app')

@section('title', 'Ajouter Séance')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ajouter une Séance</h2>
        <a href="{{ route('seances.index') }}" class="btn btn-primary">← Retour</a>
    </div>
    <form action="{{ route('seances.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Jour</label>
            <select name="jour" required>
                <option value="">-- Choisir un jour --</option>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
            </select>
        </div>
        <div class="form-group">
            <label>Heure Début</label>
            <input type="time" name="heure_deb" required>
        </div>
        <div class="form-group">
            <label>Heure Fin</label>
            <input type="time" name="heure_fin" required>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre">
                <option value="">-- Choisir --</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
                <option value="S5">S5</option>
                <option value="S6">S6</option>
            </select>
        </div>
        <div class="form-group">
            <label>Filière</label>
            <select id="filiere-select" name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Module</label>
            <select id="module-select" name="module_id" required disabled>
                <option value="">-- Sélectionnez filière + étape --</option>
            </select>
        </div>
        <div class="form-group">
            <label>Professeur</label>
            <select name="prof_id" required>
                <option value="">-- Choisir un professeur --</option>
                @foreach($profs as $prof)
                    <option value="{{ $prof->id }}">{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </form>

    <script>
        const filiereSelect = document.getElementById('filiere-select');
        const etapeSelect = document.getElementById('etape-select');
        const moduleSelect = document.getElementById('module-select');
        
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
                    moduleSelect.innerHTML = '<option value="">-- Choisir module --</option>';
                    modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.nom;
                        moduleSelect.appendChild(option);
                    });
                    moduleSelect.disabled = false;
                });
        });
    </script>
</div>
@endsection
