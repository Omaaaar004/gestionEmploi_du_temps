<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Module;
use App\Models\Prof;
use App\Models\Filiere;
use App\Models\Semestre;
use App\Models\Locals;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index(Request $request)
    {
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        $view = $request->get('view', 'grid'); // default: grille

        if ($request->filiere_id && $request->semestre_id) {
            $seances = Seance::with(['module', 'prof', 'filiere', 'semestre', 'local'])
                ->where('filiere_id', $request->filiere_id)
                ->where('semestre_id', $request->semestre_id)
                ->get();
        } else {
            $seances = collect();
        }

            

        return view('seances.index', compact('seances', 'view', 'filieres', 'semestres'));
    }

    public function events(Request $request)
    {
        $query = Seance::with(['module', 'prof', 'filiere', 'semestre', 'local']);

        if ($request->filiere_id) {
            $query->where('filiere_id', $request->filiere_id);
        }

        if ($request->semestre_id) {
            $query->where('semestre_id', $request->semestre_id);
        }

        $seances = $query->get();

        $events = $seances->map(function ($s) {
            return [
                'id'         => $s->id,
                'title'      => $s->module->nom . ' - ' . $s->prof->nom,
                'daysOfWeek' => [$this->mapJourToNumber($s->jour)],
                'startTime'  => $s->heure_deb,
                'endTime'    => $s->heure_fin,
                'extendedProps' => [
                    'prof'     => $s->prof->nom . ' ' . $s->prof->prenom,
                    'filiere'  => $s->filiere->nom,
                    'semestre' => $s->semestre->nom,
                    'module'   => $s->module->nom,
                    'local'    => $s->local ? $s->local->nom_local : '-',
                ]
            ];
        });

        return response()->json($events);
    }

    public function create()
    {
        $profs    = Prof::all();
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        $modules  = Module::all();
        $locals   = Locals::all();
        return view('seances.create', compact('profs', 'filieres', 'semestres', 'modules', 'locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jour'       => 'required|string',
            'heure_deb'  => 'required',
            'heure_fin'  => 'required|after:heure_deb',
            'prof_id'    => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id'=> 'required|exists:semestres,id',
            'module_id'  => 'required|exists:modules,id',
            'local_id'   => 'nullable|exists:locals,id',
        ]);

        $conflicts = [];

        // Vérification Conflit Professeur
        $profConflict = Seance::where('jour', $request->jour)
            ->where('prof_id', $request->prof_id)
            ->where(function ($q) use ($request) {
                $q->where('heure_deb', '<', $request->heure_fin)
                  ->where('heure_fin', '>', $request->heure_deb);
            })->exists();

        if ($profConflict) {
            $conflicts[] = "⚠️ Le professeur choisi est déjà occupé sur ce créneau.";
        }

        // Vérification Conflit Local (Salle)
        if ($request->local_id) {
            $localConflict = Seance::where('jour', $request->jour)
                ->where('local_id', $request->local_id)
                ->where(function ($q) use ($request) {
                    $q->where('heure_deb', '<', $request->heure_fin)
                      ->where('heure_fin', '>', $request->heure_deb);
                })->exists();

            if ($localConflict) {
                $conflicts[] = "⚠️ La salle (local) choisie est déjà occupée.";
            }
        }

        // Vérification Conflit Filière/Semestre
        $filiereConflict = Seance::where('jour', $request->jour)
            ->where('filiere_id', $request->filiere_id)
            ->where('semestre_id', $request->semestre_id)
            ->where(function ($q) use ($request) {
                $q->where('heure_deb', '<', $request->heure_fin)
                  ->where('heure_fin', '>', $request->heure_deb);
            })->exists();

        if ($filiereConflict) {
            $conflicts[] = "⚠️ Ce groupe (Filière/Semestre) a déjà un autre cours à cette heure.";
        }

        if (!empty($conflicts)) {
            return back()->withInput()->with('error_list', $conflicts);
        }

        Seance::create([
            'jour'       => $request->jour,
            'heure_deb'  => $request->heure_deb,
            'heure_fin'  => $request->heure_fin,
            'prof_id'    => $request->prof_id,
            'filiere_id' => $request->filiere_id,
            'semestre_id'=> $request->semestre_id,
            'module_id'  => $request->module_id,
            'local_id'   => $request->local_id,
        ]);

        return redirect()->route('seances.index')->with('success', 'Séance Ajoutée !');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $seance   = Seance::findOrFail($id);
        $profs    = Prof::all();
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        $modules  = Module::all();
        $locals   = Locals::all();
        return view('seances.edit', compact('seance', 'profs', 'filieres', 'semestres', 'modules', 'locals'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jour'       => 'required|string',
            'heure_deb'  => 'required',
            'heure_fin'  => 'required|after:heure_deb',
            'prof_id'    => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id'=> 'required|exists:semestres,id',
            'module_id'  => 'required|exists:modules,id',
            'local_id'   => 'nullable|exists:locals,id',
        ]);

        $conflicts = [];

        // Vérification Conflit Professeur (en excluant la séance actuelle)
        $profConflict = Seance::where('id', '!=', $id)
            ->where('jour', $request->jour)
            ->where('prof_id', $request->prof_id)
            ->where(function ($q) use ($request) {
                $q->where('heure_deb', '<', $request->heure_fin)
                  ->where('heure_fin', '>', $request->heure_deb);
            })->exists();

        if ($profConflict) {
            $conflicts[] = "⚠️ Le professeur choisi est déjà occupé sur ce créneau.";
        }

        // Vérification Conflit Local (en excluant la séance actuelle)
        if ($request->local_id) {
            $localConflict = Seance::where('id', '!=', $id)
                ->where('jour', $request->jour)
                ->where('local_id', $request->local_id)
                ->where(function ($q) use ($request) {
                    $q->where('heure_deb', '<', $request->heure_fin)
                      ->where('heure_fin', '>', $request->heure_deb);
                })->exists();

            if ($localConflict) {
                $conflicts[] = "⚠️ La salle (local) choisie est déjà occupée.";
            }
        }

        // Vérification Conflit Filière/Semestre (en excluant la séance actuelle)
        $filiereConflict = Seance::where('id', '!=', $id)
            ->where('jour', $request->jour)
            ->where('filiere_id', $request->filiere_id)
            ->where('semestre_id', $request->semestre_id)
            ->where(function ($q) use ($request) {
                $q->where('heure_deb', '<', $request->heure_fin)
                  ->where('heure_fin', '>', $request->heure_deb);
            })->exists();

        if ($filiereConflict) {
            $conflicts[] = "⚠️ Ce groupe (Filière/Semestre) a déjà un autre cours à cette heure.";
        }

        if (!empty($conflicts)) {
            return back()->withInput()->with('error_list', $conflicts);
        }

        $seance = Seance::findOrFail($id);
        $seance->jour       = $request->jour;
        $seance->heure_deb  = $request->heure_deb;
        $seance->heure_fin  = $request->heure_fin;
        $seance->prof_id    = $request->prof_id;
        $seance->filiere_id = $request->filiere_id;
        $seance->semestre_id= $request->semestre_id;
        $seance->module_id  = $request->module_id;
        $seance->local_id   = $request->local_id;
        $seance->save();

        return redirect()->route('seances.index')->with('success', 'Séance modifiée !');
    }

    public function destroy(string $id)
    {
        Seance::findOrFail($id)->delete();
        return redirect()->route('seances.index')->with('success', 'Séance supprimée !');
    }

    public function getModulesByFiliereAndSemestre($filiereId, $semestreId)
    {
        $modules = Module::where('filiere_id', $filiereId)
                         ->where('semestre_id', $semestreId)
                         ->get();
        return response()->json($modules);
    }

    public function getSemestresByFiliere($filiereId)
    {
        $semestres = Semestre::where('filiere_id', $filiereId)->get();
        return response()->json($semestres);
    }

    private function mapJourToNumber($jour)
    {
        return [
            'Dimanche' => 0,
            'Lundi'    => 1,
            'Mardi'    => 2,
            'Mercredi' => 3,
            'Jeudi'    => 4,
            'Vendredi' => 5,
            'Samedi'   => 6,
        ][$jour] ?? 1;
    }
}
