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
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                    <option value="{{ $j }}">{{ $j }}</option>
                @endforeach
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
            <select name="semestre_id" id="semestre-select" disabled required>
                <option value="">-- Choisir d'abord une filière --</option>
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
                    <option value="{{ $prof->id }}">{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Local (Optionnel)</label>
            <select name="local_id">
                <option value="">-- Choisir un local --</option>
                @foreach($locals as $local)
                    <option value="{{ $local->id }}">{{ $local->nom_local }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Enregistrer la séance</button>
    </form>

    <script>
        const filiereSelect = document.getElementById('filiere-select');
        const semestreSelect = document.getElementById('semestre-select');
        const moduleSelect = document.getElementById('module-select');
        
        const baseUrl = "{{ url('/') }}";

        filiereSelect.addEventListener('change', function() {
            const filiereId = this.value;
            
            // Reset semestres and modules
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
                    semestres.forEach(s => {
                        const option = document.createElement('option');
                        option.value = s.id;
                        option.textContent = s.nom;
                        semestreSelect.appendChild(option);
                    });
                    semestreSelect.disabled = false;
                })
                .catch(err => {
                    console.error('Erreur chargement semestres:', err);
                    semestreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
        
        semestreSelect.addEventListener('change', function() {
            const filiereId = filiereSelect.value;
            const semestreId = this.value;
            
            moduleSelect.innerHTML = '<option value="">-- Chargement... --</option>';
            moduleSelect.disabled = true;

            if (!filiereId || !semestreId) {
                moduleSelect.innerHTML = '<option value="">-- Sélectionnez d\'abord un semestre --</option>';
                return;
            }
            
            fetch(`${baseUrl}/seances/modules/${filiereId}/${semestreId}`)
                .then(response => response.json())
                .then(modules => {
                    moduleSelect.innerHTML = '<option value="">-- Choisir un module --</option>';
                    if (modules.length === 0) {
                        moduleSelect.innerHTML = '<option value="">Aucun module trouvé</option>';
                    } else {
                        modules.forEach(m => {
                            const option = document.createElement('option');
                            option.value = m.id;
                            option.textContent = m.nom;
                            moduleSelect.appendChild(option);
                        });
                        moduleSelect.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Erreur chargement modules:', err);
                    moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
    </script>
</div>
@endsection
