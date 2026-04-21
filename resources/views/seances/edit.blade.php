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
            <label>Semestre</label>
            <select name="semestre_id" id="semestre-select" required disabled>
                <option value="">-- Chargement... --</option>
            </select>
        </div>
        <div class="form-group">
            <label>Module</label>
            <select id="module-select" name="module_id" required disabled>
                <option value="">-- Sélectionnez d'abord un semestre --</option>
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
        <div class="form-group">
            <label>Local (Optionnel)</label>
            <select name="local_id">
                <option value="">-- Choisir un local --</option>
                @foreach($locals as $local)
                    <option value="{{ $local->id }}" {{ $seance->local_id == $local->id ? 'selected' : '' }}>{{ $local->nom_local }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
    </form>

    <script>
        const filiereSelect = document.getElementById('filiere-select');
        const semestreSelect = document.getElementById('semestre-select');
        const moduleSelect = document.getElementById('module-select');

        const currentSemestreId = '{{ $seance->semestre_id }}';
        const currentModuleId = '{{ $seance->module_id }}';
        const baseUrl = "{{ url('/') }}";
        
        filiereSelect.addEventListener('change', function() {
            const filiereId = this.value;
            semestreSelect.innerHTML = '<option value="">-- Chargement... --</option>';
            semestreSelect.disabled = true;
            moduleSelect.innerHTML = '<option value="">-- Sélectionnez d\'abord un semestre --</option>';
            moduleSelect.disabled = true;
            
            if (!filiereId) {
                semestreSelect.innerHTML = '<option value="">-- Choisir d\'abord une filière --</option>';
                return;
            }
            
            fetch(`${baseUrl}/seances/semestres/${filiereId}`)
                .then(response => response.json())
                .then(semestres => {
                    semestreSelect.innerHTML = '<option value="">-- Choisir un semestre --</option>';
                    semestres.forEach(semestre => {
                        const option = document.createElement('option');
                        option.value = semestre.id;
                        option.textContent = semestre.nom;
                        if(semestre.id == currentSemestreId) option.selected = true;
                        semestreSelect.appendChild(option);
                    });
                    semestreSelect.disabled = false;
                    
                    // Trigger semestre change to load modules if we have a currentSemestreId
                    if(semestreSelect.value) {
                        semestreSelect.dispatchEvent(new Event('change'));
                    }
                })
                .catch(err => console.error('Erreur semestres:', err));
        });
        
        semestreSelect.addEventListener('change', function() {
            const filiereId = filiereSelect.value;
            const semestreId = this.value;
            
            moduleSelect.innerHTML = '<option value="">-- Chargement... --</option>'
            moduleSelect.disabled = true;
            
            if (!filiereId || !semestreId) {
                moduleSelect.innerHTML = '<option value="">-- Sélectionnez d\'abord un semestre --</option>';
                return;
            }
            
            fetch(`${baseUrl}/seances/modules/${filiereId}/${semestreId}`)
                .then(response => response.json())
                .then(modules => {
                    moduleSelect.innerHTML = '<option value="">-- Choisir un module --</option>';
                    modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.nom;
                        if (module.id == currentModuleId) option.selected = true;
                        moduleSelect.appendChild(option);
                    });
                    moduleSelect.disabled = false;
                })
                .catch(err => console.error('Erreur modules:', err));
        });
        
        // Initial load
        window.addEventListener('load', function(){
            if(filiereSelect.value){
                filiereSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</div>
@endsection
