<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Module;
use App\Models\Prof;
use App\Models\Filiere;
use Illuminate\Http\Request;

class seanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filieres = Filiere::all();
        return view('seances.index', compact('filieres'));
    }

    public function events(Request $request)
    {
        $query = Seance::with(['module', 'prof', 'filiere']);

        if ($request->filiere_id) {
            $query->where('filiere_id', $request->filiere_id);
        }

        if ($request->semestre) {
            $query->where('semestre', $request->semestre);
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
                    'module' => $s->module->nom,
                    'prof' => $s->prof->nom,
                    'filiere' => $s->filiere->nom,
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
        $modules = Module::all();
        $profs = Prof::all();
        $filieres = Filiere::all();
        return view('seances.create', compact('modules', 'profs', 'filieres'));
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
            'semestre' => 'nullable|string',
            'module_id' => 'required|exists:modules,id',
            'prof_id' => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);
        Seance::create([
            'jour' => $request->jour,
            'heure_deb' => $request->heure_deb,
            'heure_fin' => $request->heure_fin,
            'semestre' => $request->semestre,
            'module_id' => $request->module_id,
            'prof_id' => $request->prof_id,
            'filiere_id' => $request->filiere_id
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
        $modules = Module::all();
        $profs = Prof::all();
        $filieres = Filiere::all();

        return view('seances.edit', compact('seance', 'modules', 'profs', 'filieres'));
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
            'semestre' => 'nullable|string',
            'module_id' => 'required|exists:modules,id',
            'prof_id' => 'required|exists:profs,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);
        $seance = Seance::findOrFail($id);
        $seance->jour = $request->jour;
        $seance->heure_deb = $request->heure_deb;
        $seance->heure_fin = $request->heure_fin;
        $seance->semestre = $request->semestre;
        $seance->module_id = $request->module_id;
        $seance->prof_id = $request->prof_id;
        $seance->filiere_id = $request->filiere_id;
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
