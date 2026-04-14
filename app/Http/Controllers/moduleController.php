<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Etape;
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
        $etapes = Etape::all();
        return view('modules.create', compact('etapes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'etape_id' => 'required|exists:etapes,id',
        ]);
        Module::create([
            'nom' => $request->nom,
            'etape_id' => $request->etape_id,
        ]);
        return redirect()->route('modules.index')->with('success', 'Module ajouté !');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $etapes = Etape::all();
        return view('modules.edit', compact('module', 'etapes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'etape_id' => 'required|exists:etapes,id',
        ]);
        $module = Module::findOrFail($id);
        $module->nom = $request->nom;
        $module->etape_id = $request->etape_id;
        $module->save();
        return redirect()->route('modules.index')->with('success', 'Module modifié !');
    }

    public function destroy($id)
    {
        Module::findOrFail($id)->delete();
        return redirect()->route('modules.index')->with('success', 'Module supprimé !');
    }
}