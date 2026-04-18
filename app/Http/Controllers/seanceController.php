<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Module;
use App\Models\Prof;
use App\Models\Filiere;
use App\Models\Semestre;
use Illuminate\Http\Request;

class seanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = Seance::with(['module', 'prof', 'filiere','semestre']);
        $filieres = Filiere::all();

        if ($request->filiere_id) {
            $query->where('filiere_id', $request->filiere_id);
        }

        if ($request->semestre_id) {
            $query->where('semestre_id', $request->semestre_id);
        }

        $seances = $query->get();

        $view = $request->get('view', 'calendar'); // default to calendar

        return view('seances.index', compact('seances', 'view','filieres'));
    }

    public function events(Request $request)
    {
        $query = Seance::with(['module', 'prof', 'filiere','semestre']);

        if ($request->filiere_id) {
            $query->where('filiere_id', $request->filiere_id);
        }

        if ($request->semestre_id) {
            $query->where('semestre_id', $request->semestre_id);
        }

        $seances = $query->get();

        $events = $seances->map(function ($s) {

            return [
                'id' => $s->id,
                'title' => $s->module->nom . ' - ' . $s->prof->nom,
                'daysOfWeek' => [$this->mapJourToNumber($s->jour)],
                'startTime' => $s->heure_deb,
                'endTime' => $s->heure_fin,
                'extendedProps' => [
                    'prof' => $s->prof->nom,
                    'filiere' => $s->filiere->nom,
                    'semestre' => $s->semestre->nom,
                    'module' => $s->module->nom
                ]
            ];
        });
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $profs = Prof::all();
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        $modules = Module::all();
        return view('seances.create', compact('profs', 'filieres','semestres','modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jour' => 'required|string',
            'heure_deb' => 'required',
            'heure_fin' => 'required|after:heure_deb',
            'prof_id' => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id'=> 'required|exists:filieres,id',
            'module_id' => 'required|exists:modules,id'
        ]);
        Seance::create([
            'jour' => $request->jour,
            'heure_deb' => $request->heure_deb,
            'heure_fin' => $request->heure_fin,
            'prof_id' => $request->prof_id,
            'filiere_id' => $request->filiere_id,
            'semestre_id' => $request->semestre_id,
            'module_id' => $request->module_id
        ]);
        return redirect()->route('seances.index')->with('success', 'Séance Ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $seance = Seance::findOrFail($id);
        $profs = Profs::all(); 
        $filieres = Filiere::all();
        $semestre = Filiere::all();
        $modules = Module::all();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jour' => 'required|string',
            'heure_deb' => 'required',
            'heure_fin' => 'required|after:heure_deb',
            'prof_id' => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id' =>'required|exists:semestre,id',
            'module_id' => 'required|exists:modules,id'

        ]);
        $seance = Seance::findOrFail($id);
        $seance->jour = $request->jour;
        $seance->heure_deb = $request->heure_deb;
        $seance->heure_fin = $request->heure_fin;
        $seance->prof_id = $request->prof_id;
        $seance->filiere_id = $request->filiere_id;
        $seance->semestre_id = $request->semestre_id;
        $seance->module_id = $request->module_id;
        $seance->save();

        return redirect()->route('seances.index')->with('success', 'Séance modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seance = Seance::findOrFail($id)->delete();

        return redirect()->route('seances.index')->with('success', 'Séance supprimée !');
    }

    /**
     * Get modules for selected filiere via AJAX
     */
    public function getModulesByFiliere($filiereId)
    {
        $modules = Module::whereHas('etape.filiere', function($q) use ($filiereId) {
            $q->where('id', $filiereId);
        })->get();

        return response()->json($modules);
    }

    private function mapJourToNumber($jour)

    {
        return [
            'Dimanche' => 0,
            'Lundi' => 1,
            'Mardi' => 2,
            'Mercredi' => 3,
            'Jeudi' => 4,
            'Vendredi' => 5,
            'Samedi' => 6,
        ][$jour];
    }
}
