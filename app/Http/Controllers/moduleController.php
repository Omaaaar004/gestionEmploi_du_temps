<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Filiere;
use App\models\Semestre;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $query = Module::with(['filiere','semestre']);
        $modules = $query->get();
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        return view('modules.create', compact('filieres','semestres'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id' => 'required|exists:semestres,id',

        ]);
        Module::create([
            'nom' => $request->nom,
            'filiere_id' => $request->filiere_id,
            'semestre_id' => $request->semestre_id
        ]);
        return redirect()->route('modules.index')->with('success', 'Module ajouté !');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $filieres = Filiere::all();
        $semestres = Semestre::all();
        return view('modules.edit', compact('module','filieres','semestres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'semestre_id' => 'required|exists:semestres,id'
        ]);
        $module = Module::findOrFail($id);
        $module->nom = $request->nom;
        $module->filiere_id = $request->filiere_id;
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