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

        @if(session('error_list'))
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ef9a9a;">
                <h4 style="margin-top:0;">🚫 Conflit détecté !</h4>
                <ul style="margin-bottom:0;">
                    @foreach(session('error_list') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label>Jour</label>
            <select name="jour" required>
                <option value="">-- Choisir un jour --</option>
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                    <option value="{{ $j }}" {{ old('jour') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
            @error('jour') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Heure Début</label>
            <input type="time" name="heure_deb" value="{{ old('heure_deb') }}" required>
            @error('heure_deb') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Heure Fin</label>
            <input type="time" name="heure_fin" value="{{ old('heure_fin') }}" required>
            @error('heure_fin') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Filière</label>
            <select id="filiere-select" name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                @endforeach
            </select>
            @error('filiere_id') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Semestre</label>
            <select name="semestre_id" id="semestre-select" disabled required>
                <option value="">-- Choisir d'abord une filière --</option>
            </select>
            @error('semestre_id') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Module</label>
            <select id="module-select" name="module_id" required disabled>
                <option value="">-- Sélectionnez d'abord un semestre --</option>
            </select>
            @error('module_id') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Professeur</label>
            <select name="prof_id" required>
                <option value="">-- Choisir un professeur --</option>
                @foreach($profs as $prof)
                    <option value="{{ $prof->id }}" {{ old('prof_id') == $prof->id ? 'selected' : '' }}>{{ $prof->nom }} {{ $prof->prenom }}</option>
                @endforeach
            </select>
            @error('prof_id') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Local (Optionnel)</label>
            <select name="local_id">
                <option value="">-- Choisir un local --</option>
                @foreach($locals as $local)
                    <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>{{ $local->nom_local }}</option>
                @endforeach
            </select>
            @error('local_id') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
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
