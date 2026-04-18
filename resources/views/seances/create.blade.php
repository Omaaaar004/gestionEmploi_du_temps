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
            <label>Filière</label>
            <select id="filiere-select" name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre_id" id="semestre-select">
                <option value="">-- Choisir un semestre --</option>
                @foreach($semestres as $semestre)
                <option value="{{ $semestre->id }}">{{ $semestre->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Module</label>
            <select id="module-select" name="module_id" required disabled>
                <option value="">-- Sélectionnez filière + semestre --</option>
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
        const semestreSelect = document.getElementById('semestre-select');
        const moduleSelect = document.getElementById('module-select');
        
        filiereSelect.addEventListener('change', function() {
            const filiereId = this.value;
            semestreSelect.innerHTML = '<option value="">-- Chargement --</option>';
            semestreSelect.disabled = true;
            moduleSelect.innerHTML = '<option value="">-- Sélectionnez filière + semestre --</option>';
            moduleSelect.disabled = true;
            
            if (!filiereId) {
                semestreSelect.innerHTML = '<option value="">-- Choisir après filière --</option>';
                return;
            }
            
            fetch(`/seances/etapes/${filiereId}`)
                .then(response => response.json())
                .then(semestres => {
                    semestreSelect.innerHTML = '<option value="">-- Choisir semestre --</option>';
                    semestres.forEach(semestres => {
                        const option = document.createElement('option');
                        option.value = semestre.id;
                        option.textContent = semestre.nom;
                        semestreSelect.appendChild(option);
                    });
                    semestreSelect.disabled = false;
                });
        });
        
        etapeSelect.addEventListener('change', function() {
            const filiereId = filiereSelect.value;
            const semestreId = this.value;
            if (!filiereId || !semestreId) {
                moduleSelect.innerHTML = '<option value="">-- Sélectionnez filière + semestre --</option>';
                moduleSelect.disabled = true;
                return;
            }
            
            fetch(`/seances/modules/${filiereId}/${semestreId}`)
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
