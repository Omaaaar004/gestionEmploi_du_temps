<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Etape;
use App\Models\Filiere;
use App\models\Semestre;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('etape')->get();
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        $etapes = Etape::all();
        $semestre = Semestre::all();
        return view('modules.create', compact('filieres','etapes','semestres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'etape_id' => 'required|exists:etapes,id',
            'semestre_id' => 'required|exists:semestres,id',

        ]);
        Module::create([
            'nom' => $request->nom,
            'filiere_id' => $request->filiere_id,
            'etape_id' => $request->etape_id,
            'semestre_id' => $request->semestre_id
        ]);
        return redirect()->route('modules.index')->with('success', 'Module ajouté !');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $filieres = Filiere::all();
        $etapes = Etape::all();
        $semestres = Semestre::all();
        return view('modules.edit', compact('module','filieres','etapes','semestres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'etape_id' => 'required|exists:etapes,id',
            'semestre_id' => 'required|exists:semestre,id'
        ]);
        $module = Module::findOrFail($id);
        $module->nom = $request->nom;
        $module->filiere_id = $request->filiere_id;
        $module->etape_id = $request->etape_id;
        $module->semestre_id = $request->semestre_id;
        $module->save();
        return redirect()->route('modules.index')->with('success', 'Module modifié !');
    }

    public function destroy($id)
    {
        Module::findOrFail($id)->delete();
        return redirect()->route('modules.index')->with('success', 'Module supprimé !');
    }
}